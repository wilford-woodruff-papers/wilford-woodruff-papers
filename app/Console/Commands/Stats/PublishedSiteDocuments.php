<?php

namespace App\Console\Commands\Stats;

use App\Models\Item;
use App\Models\Stat;
use App\Models\Type;
use Illuminate\Console\Command;

class PublishedSiteDocuments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stats:published-site-documents';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate the number of published documents for the previous month';

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
        $itemCount = Item::query()
                            ->whereIn('type_id', Type::whereNull('type_id')->pluck('id')->all())
                            ->where('enabled', 1)
                            ->count();

        $previousStat = Stat::query()
                            ->where('name', 'published-site-documents')
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
            'name' => 'published-site-documents',
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
