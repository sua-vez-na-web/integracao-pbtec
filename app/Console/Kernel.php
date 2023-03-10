<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();

        $schedule->command('bills:update')->dailyAt('07:00')
            ->timezone('America/Sao_Paulo');

        $schedule->command('bills:run')->dailyAt('07:30')
            ->timezone('America/Sao_Paulo');

        $schedule->command('geiko:notification')->dailyAt('08:00')
            ->timezone('America/Sao_Paulo');

        if (env('SCHEDULE_TEST')) {
            $schedule->command('schedule:test')->hourly();
        }
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
