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
        'app\Console\Commands\Taken',
        'app\Console\Commands\Tijden',
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('takenlijst:taken')
                 ->dailyAt('09:15');

        $schedule->command('takenlijst:taken')
                 ->dailyAt('11:55');

        $schedule->command('takenlijst:taken')
                 ->dailyAt('12:15');

        $schedule->command('takenlijst:taken')
                 ->dailyAt('17:15');
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
