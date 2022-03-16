<?php

namespace App\Console\Commands\Stats;

use App\Models\Item;
use App\Models\Stat;
use App\Models\Subject;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;

class PublishedSiteSubjects extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stats:published-site-subjects';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate the number of published people and places for the previous month';

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
    public function handle()
    {
        $now = now()->subMonth();

        $peopleCount = Subject::whereEnabled(1)
                                ->whereHas('category', function (Builder $query) {
                                    $query->where('name', 'People');
                                })
                                ->whereHas('pages')
                                ->count();

        $previousPeopleStat = Stat::query()
                            ->where('name', 'published-site-people')
                            ->where('period', 'monthly')
                            ->latest()
                            ->first();

        if (! empty($previousPeopleStat)) {
            $peopleDifference = $peopleCount - $previousPeopleStat->value;
        } else {
            $peopleDifference = $peopleCount;
        }

        Stat::create([
            'name' => 'published-site-people',
            'period' => 'monthly',
            'year' => $now->year,
            'month' => $now->month,
            'day' => $now->endOfMonth()->day,
            'value' => $peopleCount,
            'difference' => $peopleDifference,
        ]);

        $placesCount = Subject::whereEnabled(1)
                                ->whereHas('category', function (Builder $query) {
                                    $query->where('name', 'Places');
                                })
                                ->whereHas('pages')
                                ->count();

        $previousPlacesStat = Stat::query()
                            ->where('name', 'published-site-places')
                            ->where('period', 'monthly')
                            ->latest()
                            ->first();

        if (! empty($previousPlacesStat)) {
            $placesDifference = $placesCount - $previousPlacesStat->value;
        } else {
            $placesDifference = $placesCount;
        }

        Stat::create([
            'name' => 'published-site-places',
            'period' => 'monthly',
            'year' => $now->year,
            'month' => $now->month,
            'day' => $now->endOfMonth()->day,
            'value' => $placesCount,
            'difference' => $placesDifference,
        ]);

        return 0;
    }
}
