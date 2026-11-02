<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
         $schedule->command('app:clear-old-logs')->daily();
         $schedule->command('app:recalculate-club-compliance')->dailyAt('00:05');
         $schedule->command('app:transfer-mon-to-kyu')->dailyAt('00:10')->timezone('Europe/Dublin');
         $schedule->command('app:send-expiry-notifications')->dailyAt('09:00')->timezone('Europe/Dublin');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
