<?php

namespace App\Console\Commands;

use App\Jobs\CalculateFirstDateForPages;
use App\Models\Item;
use Illuminate\Bus\Batch;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;

class AddFirstDateToAllItemPages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dates:add-first-date-to-all-pages {item?} {--type=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a date to all pages. Useful for pages that have no date.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $items = Item::query()
            ->where(function ($query) {
                $query->where(function ($query) {
                    $query->whereNotNull('ftp_id')
                        ->whereNull('item_id');
                })
                    ->orWhere(function ($query) {
                        $query->has('items');
                    });
            });

        if (! empty($itemId = $this->argument('item'))) {
            $items = $items->whereId($itemId);
        }

        if (! empty($typeId = $this->option('type'))) {
            $items = $items->where('type_id', $typeId);
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
            ->finally(function (Batch $batch) {
                activity('background-logs')
                    ->event('dates:add-first-date-to-all-pages')
                    ->withProperties([
                        'Batch ID: '.$batch->id.' has finished',
                    ])
                    ->log('Finished Adding first date to all pages');
            })
            ->dispatch();

        $this->info('Added '.count($jobs).' items to the queue to be processed on Batch ID: '.$batch->id);

        activity('background-logs')
            ->event('dates:add-first-date-to-all-pages')
            ->withProperties([
                'Queued '.count($jobs).' items for processing on Batch ID: '.$batch->id,
            ])
            ->log('Add first date to all pages');

        return Command::SUCCESS;
    }
}
