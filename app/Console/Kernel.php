<?php

namespace App\Console;

use Carbon\Carbon;
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
        \App\Console\Commands\Inspire::class,
        \App\Console\Commands\PublishPostsAsScheduled::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('news:publish')
            ->everyFiveMinutes()
            ->withoutOverlapping()
            ->appendOutputTo(sprintf('%s/%s.log', storage_path('logs/schedule/PublishPostsAsScheduled'), Carbon::now()->format('Y_m_d')));
    }
}
