<?php

namespace App\Console\Commands;

use App\Models\Grade;
use App\Models\Member;
use App\Support\MonToKyu;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TransferMonToKyu extends Command
{
    protected $signature = 'app:transfer-mon-to-kyu
                            {--date= : Treat this Y-m-d date as today (Europe/Dublin) }
                            {--catch-up=7 : Also process 14th birthdays from this many days before today}';

    protected $description = 'Add the mapped Kyu grade for active members who have turned 14 (Mon-to-Kyu transfer)';

    public function handle()
    {
        $today = $this->option('date')
            ? Carbon::parse($this->option('date'), 'Europe/Dublin')->startOfDay()
            : Carbon::today('Europe/Dublin');
        $since = $today->copy()->subDays((int) $this->option('catch-up'));

        $created = $skipped = $failed = 0;

        // Members born between (since - 14y) and (today - 14y); leap-day births are
        // handled when each exact birthday is computed below.
        Member::active()
            ->whereBetween('dob', [
                $since->copy()->subYears(MonToKyu::AGE)->subDay()->toDateString(),
                $today->copy()->subYears(MonToKyu::AGE)->addDay()->toDateString(),
            ])
            ->chunkById(200, function ($members) use ($today, $since, &$created, &$skipped, &$failed) {
                foreach ($members as $member) {
                    try {
                        $result = $this->transfer($member, $today, $since);
                    } catch (\Throwable $e) {
                        $failed++;
                        Log::error("Mon-to-Kyu transfer failed for member {$member->id}: {$e->getMessage()}");
                        continue;
                    }
                    $result ? $created++ : $skipped++;
                }
            });

        $this->info("Mon-to-Kyu transfer: created {$created}, skipped {$skipped}, failed {$failed}.");

        return $failed > 0 ? Command::FAILURE : Command::SUCCESS;
    }

    /** True when a Kyu grading was created for the member. */
    private function transfer(Member $member, Carbon $today, Carbon $since): bool
    {
        try {
            $birthday = Carbon::parse($member->getRawOriginal('dob'))->startOfDay()->addYearsNoOverflow(MonToKyu::AGE);
        } catch (\Throwable $e) {
            Log::warning("Mon-to-Kyu transfer skipped member {$member->id}: invalid date of birth.");

            return false;
        }

        // Compare calendar dates: "today" is a Europe/Dublin day, the birthday has no time zone.
        if ($birthday->toDateString() > $today->toDateString() || $birthday->toDateString() < $since->toDateString()) {
            return false;
        }

        if (Grade::where('member_id', $member->id)->where('auto_transferred', true)->exists()) {
            return false;
        }

        $grades = Grade::where('member_id', $member->id)
            ->whereDate('grade_date', '<=', $birthday->toDateString())
            ->orderBy('grade_date')->orderBy('id')->get();

        if ($grades->contains(fn ($g) => MonToKyu::isKyu($g->grade_level))) {
            return false;
        }

        $kyu = MonToKyu::kyuFor($grades->last()?->grade_level);
        if ($kyu === null) {
            return false;
        }

        DB::transaction(function () use ($member, $birthday, $kyu, $grades) {
            Grade::create([
                'member_id' => $member->id,
                'club_id' => $member->club_id,
                'grade_level' => $kyu,
                'grade_date' => $birthday->toDateString(),
                'auto_transferred' => true,
            ]);

            activity()->performedOn($member)->withProperties([
                'from' => $grades->last()->grade_level,
                'to' => $kyu,
                'grade_date' => $birthday->toDateString(),
            ])->log('Automatic Mon-to-Kyu grade transfer');
        });

        return true;
    }
}
