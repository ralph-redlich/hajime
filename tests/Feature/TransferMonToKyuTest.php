<?php

namespace Tests\Feature;

use App\Models\Club;
use App\Models\Grade;
use App\Models\Member;
use App\Support\MonToKyu;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransferMonToKyuTest extends TestCase
{
    use RefreshDatabase;

    private const TODAY = '2026-06-15';

    private function member(string $dob, ?string $grade, array $extra = []): Member
    {
        $member = Member::factory()->for(Club::factory())->create(array_merge(['dob' => $dob, 'active' => 1], $extra));
        if ($grade) {
            Grade::create(['member_id' => $member->id, 'grade_level' => $grade, 'grade_date' => '2025-01-01']);
        }

        return $member;
    }

    private function run14(string $date = self::TODAY, string $catchUp = '0'): void
    {
        $this->artisan('app:transfer-mon-to-kyu', ['--date' => $date, '--catch-up' => $catchUp])->assertSuccessful();
    }

    private function autoGrade(Member $member): ?Grade
    {
        return Grade::where('member_id', $member->id)->where('auto_transferred', true)->first();
    }

    public function test_legend_maps_every_row(): void
    {
        $expected = [
            '1st Shamrock' => '5th Kyu Yellow', '3rd Shamrock' => '5th Kyu Yellow',
            '2nd Mon Red' => '5th Kyu Yellow', '5th Mon Yellow/Orange' => '5th Kyu Yellow',
            '6th Mon Orange' => '4th Kyu Orange', '10th Mon Blue' => '4th Kyu Orange',
            '11th Mon Blue/Brown' => '3rd Kyu Green', '12th Mon Brown' => '3rd Kyu Green',
            '1st Mon White' => null, 'White Belt' => null, '6th Kyu White' => null, null => null,
        ];

        foreach ($expected as $from => $to) {
            $this->assertSame($to, MonToKyu::kyuFor($from), (string) $from);
        }
    }

    public function test_member_turning_14_today_gets_kyu_dated_on_birthday_and_tomorrow_does_not(): void
    {
        $today = $this->member('2012-06-15', '6th Mon Orange');
        $tomorrow = $this->member('2012-06-16', '6th Mon Orange');

        $this->run14();

        $grade = $this->autoGrade($today);
        $this->assertSame('4th Kyu Orange', $grade->grade_level);
        $this->assertSame('2026-06-15', substr($grade->grade_date, 0, 10));
        $this->assertSame($today->club_id, $grade->club_id);
        $this->assertNull($this->autoGrade($tomorrow));
    }

    public function test_no_entry_for_first_mon_no_grade_or_existing_kyu(): void
    {
        $first = $this->member('2012-06-15', '1st Mon White');
        $none = $this->member('2012-06-15', null);
        $kyu = $this->member('2012-06-15', '5th Kyu Yellow');

        $this->run14();

        $this->assertSame(0, Grade::where('auto_transferred', true)->count());
        $this->assertSame(1, Grade::where('member_id', $first->id)->count());
        $this->assertSame(0, Grade::where('member_id', $none->id)->count());
        $this->assertSame(1, Grade::where('member_id', $kyu->id)->count());
    }

    public function test_running_twice_does_not_duplicate(): void
    {
        $member = $this->member('2012-06-15', '12th Mon Brown');

        $this->run14();
        $this->run14();
        $this->run14('2026-06-16', '7');

        $this->assertSame(1, Grade::where('member_id', $member->id)->where('auto_transferred', true)->count());
    }

    public function test_catch_up_processes_a_missed_birthday_dated_on_the_birthday(): void
    {
        $member = $this->member('2012-06-12', '3rd Mon White/Yellow');

        $this->run14(self::TODAY, '7');

        $this->assertSame('2026-06-12', substr($this->autoGrade($member)->grade_date, 0, 10));
    }

    public function test_members_already_over_14_beyond_the_window_are_ignored(): void
    {
        $member = $this->member('2010-01-01', '12th Mon Brown');

        $this->run14(self::TODAY, '7');

        $this->assertNull($this->autoGrade($member));
    }

    public function test_leap_day_birthday_falls_on_28_feb_in_non_leap_year(): void
    {
        $member = $this->member('2012-02-29', '8th Mon Green');

        $this->run14('2026-02-28');

        $this->assertSame('2026-02-28', substr($this->autoGrade($member)->grade_date, 0, 10));
    }

    public function test_grade_before_birthday_is_the_one_mapped_and_manual_entries_still_work(): void
    {
        $member = $this->member('2012-06-15', '2nd Mon Red');
        Grade::create(['member_id' => $member->id, 'grade_level' => '7th Mon Orange/Green', 'grade_date' => '2026-12-01']);

        $this->run14();

        $this->assertSame('5th Kyu Yellow', $this->autoGrade($member)->grade_level);
        $manual = Grade::create(['member_id' => $member->id, 'grade_level' => '4th Kyu Orange', 'grade_date' => '2027-01-01']);
        $this->assertFalse((bool) $manual->fresh()->auto_transferred);
    }

    public function test_inactive_members_are_skipped_and_the_transfer_is_logged(): void
    {
        $inactive = $this->member('2012-06-15', '6th Mon Orange', ['active' => 0]);
        $active = $this->member('2012-06-15', '6th Mon Orange');

        $this->run14();

        $this->assertNull($this->autoGrade($inactive));
        $this->assertDatabaseHas('activity_log', [
            'description' => 'Automatic Mon-to-Kyu grade transfer',
            'subject_id' => $active->id,
        ]);
    }

    public function test_command_is_scheduled_nightly(): void
    {
        $events = collect(app(\Illuminate\Console\Scheduling\Schedule::class)->events());

        $event = $events->first(fn ($e) => str_contains($e->command, 'app:transfer-mon-to-kyu'));

        $this->assertNotNull($event);
        $this->assertSame('10 0 * * *', $event->expression);
        $this->assertSame('Europe/Dublin', (string) $event->timezone);
    }
}
