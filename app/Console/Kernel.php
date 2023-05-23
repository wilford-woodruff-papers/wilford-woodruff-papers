<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('backup:clean')->daily()->at('04:00')->timezone('America/Denver');
        $schedule->command('backup:run')->daily()->at('04:30')->timezone('America/Denver');
        $schedule->command('queue:prune-batches --hours=48')->daily();

        $schedule->command('import:instagram')
                 ->everyFourHours();

        $schedule->command('import:items')
                 ->dailyAt('1:00 AM')
                 ->withoutOverlapping()
                 ->timezone('America/Denver')
                 ->emailOutputTo('jon.fackrell@wilfordwoodruffpapers.org')
                 ->pingOnSuccess('http://beats.envoyer.io/heartbeat/wc7wzwZhcB9Jfrk');

        /*$schedule->command('import:pages')
                 ->dailyAt('2:00 AM')
                 ->timezone('America/Denver')
                 ->emailOutputTo('jon.fackrell@wilfordwoodruffpapers.org')
                 ->pingOnSuccess('http://beats.envoyer.io/heartbeat/CdvYy969jSgJpsf');*/

        $schedule->command('import:contributions')
                 ->dailyAt('2:10 AM')
                 ->withoutOverlapping()
                 ->timezone('America/Denver')
                 ->emailOutputTo('jon.fackrell@wilfordwoodruffpapers.org')
                 ->pingOnSuccess('http://beats.envoyer.io/heartbeat/NBAuq5yMAJvwwS4');

        $schedule->command('topics:index')
            ->dailyAt('4:30 AM')
            ->withoutOverlapping()
            ->timezone('America/Denver')
            ->emailOutputTo('jon.fackrell@wilfordwoodruffpapers.org')
            ->pingOnSuccess('http://beats.envoyer.io/heartbeat/kCvDa59b9eOIquc');

        $schedule->command('topics:count')
            ->dailyAt('6:10 AM')
            ->withoutOverlapping()
            ->timezone('America/Denver')
            ->emailOutputTo('jon.fackrell@wilfordwoodruffpapers.org')
            ->pingOnSuccess('http://beats.envoyer.io/heartbeat/ccbDFveJkONtDEt');

        $schedule->command('telescope:prune --hours=48')->daily();

        /* Calculate Stats */

        $schedule->command('stats:published-site-documents')
                ->monthlyOn(1, '2:00 AM')
                ->timezone('America/Denver')
                ->emailOutputTo('jon.fackrell@wilfordwoodruffpapers.org')
                ->pingOnSuccess('http://beats.envoyer.io/heartbeat/DG1hTtM5eymywll');

        $schedule->command('stats:published-site-pages')
                ->monthlyOn(1, '2:05 AM')
                ->timezone('America/Denver')
                ->emailOutputTo('jon.fackrell@wilfordwoodruffpapers.org')
                ->pingOnSuccess('http://beats.envoyer.io/heartbeat/gvKBVBtoHgXsLjB');

        $schedule->command('stats:published-site-subjects')
                ->monthlyOn(1, '2:10 AM')
                ->timezone('America/Denver')
                ->emailOutputTo('jon.fackrell@wilfordwoodruffpapers.org')
                ->pingOnSuccess('http://beats.envoyer.io/heartbeat/IHQdtqMiFKrkEjQ');

        $schedule->command('stats:site-searches')
                ->monthlyOn(1, '2:15 AM')
                ->timezone('America/Denver')
                ->emailOutputTo('jon.fackrell@wilfordwoodruffpapers.org')
                ->pingOnSuccess('http://beats.envoyer.io/heartbeat/RpoCfrCRWiDH7MT');

        $schedule->command('stats:uploaded-ftp-documents')
                ->monthlyOn(1, '2:20 AM')
                ->timezone('America/Denver')
                ->emailOutputTo('jon.fackrell@wilfordwoodruffpapers.org')
                ->pingOnSuccess('http://beats.envoyer.io/heartbeat/gy8BXgNsc8HoO7e');

        $schedule->command('stats:quotes')
            ->monthlyOn(1, '2:25 AM')
            ->timezone('America/Denver')
            ->emailOutputTo('jon.fackrell@wilfordwoodruffpapers.org')
            ->pingOnSuccess('http://beats.envoyer.io/heartbeat/jLXt6LMfXLffev0');

        $schedule->command('instagram-feed:refresh-tokens')
                ->lastDayOfMonth()
                ->emailOutputTo('jon.fackrell@wilfordwoodruffpapers.org');

        $schedule->command('newsletters:import')
            ->dailyAt('4:10 AM')
            ->timezone('America/Denver')
            ->emailOutputTo('jon.fackrell@wilfordwoodruffpapers.org');

        $schedule->command('pages:export')
            ->weeklyOn(0, '4:00')
            ->withoutOverlapping()
            ->timezone('America/Denver')
            ->emailOutputTo('jon.fackrell@wilfordwoodruffpapers.org')
            ->pingOnSuccess('http://beats.envoyer.io/heartbeat/hh0S9mWgC3Gc8ky');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
