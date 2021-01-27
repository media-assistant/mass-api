<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array<string>
     */
    protected $commands = [
    ];

    protected function schedule(Schedule $schedule): void
    {
    }

    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');
    }
}
