<?php

namespace App\Console\Commands\Stats;

use App\Models\Stat;
use Illuminate\Console\Command;
use Spatie\Activitylog\Models\Activity;

class SiteSearches extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stats:site-searches';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate the number of site searches for the previous month';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $now = now()->subMonth();

        $itemCount = Activity::query()
                        ->where('log_name', 'search')
                        ->whereBetween('created_at', [$now->startOfMonth()->toDateString(), $now->endOfMonth()->toDateString()])
                        ->count();

        $previousStat = Stat::query()
                            ->where('name', 'site-searches')
                            ->where('period', 'monthly')
                            ->latest()
                            ->first();

        if (! empty($previousStat)) {
            $difference = $itemCount - $previousStat->value;
        } else {
            $difference = $itemCount;
        }

        Stat::create([
            'name' => 'site-searches',
            'period' => 'monthly',
            'year' => $now->year,
            'month' => $now->month,
            'day' => $now->endOfMonth()->day,
            'value' => $itemCount,
            'difference' => $difference,
        ]);

        return 0;
    }
}
