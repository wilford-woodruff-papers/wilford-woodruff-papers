<?php

namespace App\Console\Commands\Stats;

use App\Models\Page;
use App\Models\Stat;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;

class PublishedSitePages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stats:published-site-pages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate the number of published pages for the previous month';

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
     *
     * @return int
     */
    public function handle(): int
    {
        $itemCount = Page::query()
                            ->whereHas('item', function (Builder $query) {
                                $query->where('enabled', 1);
                            })
                            ->count();

        $previousStat = Stat::query()
                            ->where('name', 'published-site-pages')
                            ->where('period', 'monthly')
                            ->latest()
                            ->first();

        if (! empty($previousStat)) {
            $difference = $itemCount - $previousStat->value;
        } else {
            $difference = $itemCount;
        }

        $now = now()->subMonth();

        Stat::create([
            'name' => 'published-site-pages',
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
