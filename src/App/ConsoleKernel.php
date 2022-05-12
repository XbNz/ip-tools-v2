<?php

declare(strict_types=1);

namespace App;

use function base_path;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel;

class ConsoleKernel extends Kernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');
        $this->load(__DIR__ . '/Console/Command');

        require base_path('routes/console.php');
    }
}
