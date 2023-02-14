<?php

namespace App\Console\Commands;

use App\Models\Item;
use Illuminate\Console\Command;

class CaculatePageCounts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pages:auto-count';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add page counts to items based on attached number of pages';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Item::query()
            ->withCount('pages')
            ->chunkById(100, function ($items) {
                foreach ($items as $item) {
                    $item->auto_page_count = $item->pages_count;
                    $item->save();
                }
            });

        return 0;
    }
}
