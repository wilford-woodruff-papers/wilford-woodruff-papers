

<?php

use Illuminate\Support\Facades\Schedule;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

/*Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');*/


Schedule::command('backup:clean')
    ->daily()
    ->at('04:00')
    ->timezone('America/Denver');
Schedule::command('backup:run')
    ->daily()
    ->at('04:30')
    ->timezone('America/Denver');

Schedule::command('queue:prune-batches --hours=48')
    ->daily();

Schedule::command('import:instagram')
    ->everyFourHours();

Schedule::command('import:items')
    ->dailyAt('1:00 AM')
    ->withoutOverlapping()
    ->timezone('America/Denver')
    ->emailOutputTo('jon.fackrell@wilfordwoodruffpapers.org')
    ->pingOnSuccess('http://beats.envoyer.io/heartbeat/wc7wzwZhcB9Jfrk');

/*Schedule::command('import:pages')
         ->dailyAt('2:00 AM')
         ->timezone('America/Denver')
         ->emailOutputTo('jon.fackrell@wilfordwoodruffpapers.org')
         ->pingOnSuccess('http://beats.envoyer.io/heartbeat/CdvYy969jSgJpsf');*/

Schedule::command('import:contributions')
    ->dailyAt('2:10 AM')
    ->withoutOverlapping()
    ->timezone('America/Denver')
    ->emailOutputTo('jon.fackrell@wilfordwoodruffpapers.org')
    ->pingOnSuccess('http://beats.envoyer.io/heartbeat/NBAuq5yMAJvwwS4');

Schedule::command('uncat:export')
    ->dailyAt('8:30 AM')
    ->withoutOverlapping()
    ->timezone('America/Denver')
    ->emailOutputTo('jon.fackrell@wilfordwoodruffpapers.org');

Schedule::command('subjects:import')
    ->dailyAt('8:15 AM')
    ->withoutOverlapping()
    ->timezone('America/Denver')
    ->emailOutputTo('jon.fackrell@wilfordwoodruffpapers.org');

Schedule::command('topics:index')
    ->dailyAt('4:30 AM')
    ->withoutOverlapping()
    ->timezone('America/Denver')
    ->emailOutputTo('jon.fackrell@wilfordwoodruffpapers.org')
    ->pingOnSuccess('http://beats.envoyer.io/heartbeat/kCvDa59b9eOIquc');

Schedule::command('topics:count')
    ->dailyAt('6:10 AM')
    ->withoutOverlapping()
    ->timezone('America/Denver')
    ->emailOutputTo('jon.fackrell@wilfordwoodruffpapers.org')
    ->pingOnSuccess('http://beats.envoyer.io/heartbeat/ccbDFveJkONtDEt');

Schedule::command('telescope:prune --hours=48')
    ->daily();

/* Calculate Stats */

Schedule::command('stats:published-site-documents')
    ->monthlyOn(1, '2:00 AM')
    ->timezone('America/Denver')
    ->emailOutputTo('jon.fackrell@wilfordwoodruffpapers.org')
    ->pingOnSuccess('http://beats.envoyer.io/heartbeat/DG1hTtM5eymywll');

Schedule::command('stats:published-site-pages')
    ->monthlyOn(1, '2:05 AM')
    ->timezone('America/Denver')
    ->emailOutputTo('jon.fackrell@wilfordwoodruffpapers.org')
    ->pingOnSuccess('http://beats.envoyer.io/heartbeat/gvKBVBtoHgXsLjB');

Schedule::command('stats:published-site-subjects')
    ->monthlyOn(1, '2:10 AM')
    ->timezone('America/Denver')
    ->emailOutputTo('jon.fackrell@wilfordwoodruffpapers.org')
    ->pingOnSuccess('http://beats.envoyer.io/heartbeat/IHQdtqMiFKrkEjQ');

Schedule::command('stats:site-searches')
    ->monthlyOn(1, '2:15 AM')
    ->timezone('America/Denver')
    ->emailOutputTo('jon.fackrell@wilfordwoodruffpapers.org')
    ->pingOnSuccess('http://beats.envoyer.io/heartbeat/RpoCfrCRWiDH7MT');

Schedule::command('stats:uploaded-ftp-documents')
    ->monthlyOn(1, '2:20 AM')
    ->timezone('America/Denver')
    ->emailOutputTo('jon.fackrell@wilfordwoodruffpapers.org')
    ->pingOnSuccess('http://beats.envoyer.io/heartbeat/gy8BXgNsc8HoO7e');

Schedule::command('stats:quotes')
    ->monthlyOn(1, '2:25 AM')
    ->timezone('America/Denver')
    ->emailOutputTo('jon.fackrell@wilfordwoodruffpapers.org')
    ->pingOnSuccess('http://beats.envoyer.io/heartbeat/jLXt6LMfXLffev0');

Schedule::command('instagram-feed:refresh-tokens')
    ->lastDayOfMonth()
    ->emailOutputTo('jon.fackrell@wilfordwoodruffpapers.org');

Schedule::command('newsletters:import')
    ->dailyAt('4:10 AM')
    ->timezone('America/Denver')
    ->emailOutputTo('jon.fackrell@wilfordwoodruffpapers.org');

/* Export CSVs for API */
Schedule::command('pages:export')
    ->weeklyOn(0, '4:00')
    ->withoutOverlapping()
    ->timezone('America/Denver')
    ->emailOutputTo('jon.fackrell@wilfordwoodruffpapers.org');

Schedule::command('people:export')
    ->weeklyOn(6, '10:00')
    ->withoutOverlapping()
    ->timezone('America/Denver')
    ->emailOutputTo('jon.fackrell@wilfordwoodruffpapers.org');

Schedule::command('places:export')
    ->weeklyOn(6, '10:30')
    ->withoutOverlapping()
    ->timezone('America/Denver')
    ->emailOutputTo('jon.fackrell@wilfordwoodruffpapers.org');

//        $schedule
//            ->command('topics:count')
//            ->weeklyOn(6, '11:00')
//            ->withoutOverlapping()
//            ->timezone('America/Denver')
//            ->emailOutputTo('jon.fackrell@wilfordwoodruffpapers.org');

Schedule::command('items:export')
    ->weeklyOn(6, '11:30')
    ->withoutOverlapping()
    ->timezone('America/Denver')
    ->emailOutputTo('jon.fackrell@wilfordwoodruffpapers.org');

//        $schedule
//            ->command('relationships:process')
//            ->everyFiveMinutes()
//            ->withoutOverlapping()
//            ->timezone('America/Denver')
//            ->emailOutputTo('jon.fackrell@wilfordwoodruffpapers.org');

Schedule::command('banner:generate-count 7')
    ->weeklyOn(6, '03:00')
    ->withoutOverlapping()
    ->timezone('America/Denver');
