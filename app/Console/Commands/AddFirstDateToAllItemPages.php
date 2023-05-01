<?php

namespace App\Console\Commands;

use App\Jobs\CalculateFirstDateForPages;
use App\Models\Item;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;

class AddFirstDateToAllItemPages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dates:add-first-date-to-all-pages {item?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a date to all pages. Usefull for pages that have no date.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $items = Item::query()
            ->whereNotNull('ftp_id')
            ->whereNull('item_id');

        if (! empty($itemId = $this->argument('item'))) {
            $items = $items->whereId($itemId);
        }

        $items = $items->get();

        $jobs = [];
        foreach ($items as $item) {
            $jobs[] = new CalculateFirstDateForPages($item);
        }

        $batch = Bus::batch($jobs)
            ->onQueue('pages')
            ->name('Calculate First Date for Pages')
            ->allowFailures()
            ->dispatch();

        $this->info('Batch ID: '.$batch->id);

        return Command::SUCCESS;
    }
}
