<?php

namespace App\Console\Commands\Stats;

use App\Models\Item;
use App\Models\Page;
use App\Models\Quote;
use App\Models\Stat;
use Illuminate\Console\Command;

class QuoteTaggedDocuments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stats:quotes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate the number of pages and documents tagged with quotes';

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
        // Store quote count
        $quoteCount = Quote::query()
                            ->where(function ($query) {
                                $query->whereNull('continued_from_previous_page')
                                    ->orWhere('continued_from_previous_page', 0);
                            })
                            ->count();

        $previousQuoteCount = Stat::query()
                                    ->where('name', 'tagged-quotes')
                                    ->where('period', 'monthly')
                                    ->latest()
                                    ->first();

        if (! empty($previousQuoteCount)) {
            $difference = $quoteCount - $previousQuoteCount->value;
        } else {
            $difference = $quoteCount;
        }

        $now = now()->subMonth();

        Stat::create([
            'name' => 'tagged-quotes',
            'period' => 'monthly',
            'year' => $now->year,
            'month' => $now->month,
            'day' => $now->endOfMonth()->day,
            'value' => $quoteCount,
            'difference' => $difference,
        ]);

        // Store page count
        $pageCount = Quote::query()
                        ->selectRaw('DISTINCT(page_id)')
                        ->count();

        $previousPageCount = Stat::query()
            ->where('name', 'page-tagged-quotes')
            ->where('period', 'monthly')
            ->latest()
            ->first();

        if (! empty($previousPageCount)) {
            $difference = $pageCount - $previousPageCount->value;
        } else {
            $difference = $pageCount;
        }

        $now = now()->subMonth();

        Stat::create([
            'name' => 'page-tagged-quotes',
            'period' => 'monthly',
            'year' => $now->year,
            'month' => $now->month,
            'day' => $now->endOfMonth()->day,
            'value' => $pageCount,
            'difference' => $difference,
        ]);

        // Store document count
        $itemIds = Page::query()
            ->selectRaw('DISTINCT(item_id)')
            ->whereIn('id',
                Quote::query()
                        ->selectRaw('DISTINCT(page_id)')
                            ->pluck('page_id')
                            ->all()
            )
            ->pluck('item_id')
            ->all();

        $documentCount = Item::query()
                            ->whereIn('id', $itemIds)
                            ->count();

        $previousDocumentCount = Stat::query()
            ->where('name', 'item-tagged-quotes')
            ->where('period', 'monthly')
            ->latest()
            ->first();

        if (! empty($previousDocumentCount)) {
            $difference = $documentCount - $previousDocumentCount->value;
        } else {
            $difference = $documentCount;
        }

        $now = now()->subMonth();

        Stat::create([
            'name' => 'item-tagged-quotes',
            'period' => 'monthly',
            'year' => $now->year,
            'month' => $now->month,
            'day' => $now->endOfMonth()->day,
            'value' => $documentCount,
            'difference' => $difference,
        ]);

        return 0;
    }
}
