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
        $schedule->command('import:items')
                 ->dailyAt('1:00 AM')
                 ->timezone('America/Denver')
                 ->emailOutputTo('jon.fackrell@wilfordwoodruffpapers.org')
                 ->pingOnSuccess('http://beats.envoyer.io/heartbeat/wc7wzwZhcB9Jfrk');

        $schedule->command('import:pages')
                 ->weeklyOn(5, '2:00 AM')
                 ->timezone('America/Denver')
                 ->emailOutputTo('jon.fackrell@wilfordwoodruffpapers.org')
                 ->pingOnSuccess('http://beats.envoyer.io/heartbeat/CdvYy969jSgJpsf');

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
