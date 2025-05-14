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
        // Register the ProcessAutomatedPayments command here
        Commands\ProcessAutomatedPayments::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Schedule the automated payment processing to run daily at midnight
        $schedule->command('app:process-automated-payments')->dailyAt('00:00'); // Can be adjusted to your preferred time
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        // Load the console commands
        $this->load(__DIR__.'/Commands');

        // Load the default Laravel command definitions
        require base_path('routes/console.php');
    }
}
