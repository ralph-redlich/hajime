<?php

namespace App\Console\Commands;

use App\Support\InvalidClubPersonnel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TransferSafeguardingExpiry extends Command
{
    protected $signature = 'app:transfer-safeguarding-expiry
                            {--dry-run : Report what would change without writing}';

    protected $description = 'Copy the legacy safeguarding_expiry into the level column required by the person\'s role (L1/L2/L3)';

    /** Tables holding the legacy column. Coaches and volunteers have no role column and always need L1. */
    private const TABLES = ['personnels', 'coaches', 'volunteers'];

    public function handle()
    {
        $dry = (bool) $this->option('dry-run');
        $totals = [1 => 0, 2 => 0, 3 => 0];
        $skipped = 0;

        foreach (self::TABLES as $table) {
            $hasRole = $table === 'personnels';

            DB::table($table)->whereNotNull('safeguarding_expiry')->orderBy('id')
                ->chunkById(200, function ($rows) use ($table, $hasRole, $dry, &$totals, &$skipped) {
                    foreach ($rows as $row) {
                        $level = $hasRole ? InvalidClubPersonnel::requiredLevel($row->role) : 1;
                        $column = "safeguarding_l{$level}_expiry";

                        // Never overwrite a date already entered for the level.
                        if ($row->{$column} !== null && $row->{$column} !== '') {
                            $skipped++;
                            continue;
                        }

                        $totals[$level]++;
                        if (! $dry) {
                            // Guarded in the query too, so a date saved since the read is never overwritten.
                            DB::table($table)->where('id', $row->id)
                                ->where(fn ($q) => $q->whereNull($column)->orWhere($column, ''))
                                ->update([$column => $row->safeguarding_expiry]);
                        }
                    }
                });
        }

        $this->info(($dry ? '[dry run] ' : '')."Safeguarding expiry transfer: L1 {$totals[1]}, L2 {$totals[2]}, L3 {$totals[3]}, skipped (level already set) {$skipped}.");

        return Command::SUCCESS;
    }
}
