<?php

namespace App\Console\Commands;

use App\Jobs\ImportItemFromFtp;
use App\Models\Item;
use Illuminate\Bus\Batch;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;

class HarvestPagesFromThePage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:pages {item?} {--enable=false}  {--download=false}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import pages from From the Page';

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
        $items = Item::query()
            ->whereNotNull('ftp_id');

        if (! empty($itemId = $this->argument('item'))) {
            $items = $items->whereId($itemId);
        }

        $items = $items->get();

        $jobs = [];
        foreach ($items as $item) {
            $jobs[] = new ImportItemFromFtp($item, $this->option('enable'), $this->option('download'));
        }

        $batch = Bus::batch($jobs)
            ->onQueue('pages')
            ->name('Import Pages')
            ->allowFailures()
            ->finally(function (Batch $batch) {
                activity('background-logs')
                    ->event('import:pages')
                    ->withProperties([
                        'Batch ID: '.$batch->id.' has finished',
                    ])
                    ->log('Finished Importing Pages from FTP');
            })
            ->dispatch();

        $this->info('Added '.count($jobs).' items to the queue to be processed on Batch ID: '.$batch->id);

        activity('background-logs')
            ->event('import:pages')
            ->withProperties([
                'item='.$this->argument('item'),
                '--enable='.$this->option('enable'),
                '--download='.$this->option('download'),
                'Queued '.count($jobs).' items for processing on Batch ID: '.$batch->id,
            ])
            ->log('Pages Imported from FTP');

        return Command::SUCCESS;
    }
}
