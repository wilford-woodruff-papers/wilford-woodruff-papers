<?php

namespace App\Console\Commands;

use App\Jobs\ImportItemFromFtp;
use App\Models\Item;
use Illuminate\Bus\Batch;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Http;

class ImportNewPageContributions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:contributions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check new contributions and import updates';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Todo: Set start and end times
        $now = now('America/Denver');
        $response = Http::get('https://fromthepage.com/iiif/contributions/woodruff/' . $now->subHours(24)->tz('UTC')->toIso8601String() . '/' . $now->tz('UTC')->toIso8601String());

        $manifests = collect($response->json('manifests', []));

        $items = Item::query()
            ->where('enabled', 1)
            ->whereIn('ftp_id', $manifests->pluck('@id'))
            ->get();

        if($items->count() > 0){
            $jobs = [];
            foreach ($items as $item) {
                $jobs[] = new ImportItemFromFtp($item);
            }

            $batch = Bus::batch($jobs)
                ->then(function (Batch $batch) {
                    // All jobs completed successfully...
                    Bus::chain([
                        new \App\Jobs\OrderPages(),
                        new \App\Jobs\CacheDates(),
                    ])
                        ->dispatch();
                })
                ->name('Import New Pages Contributions')
                ->allowFailures()
                ->dispatch();

            $this->info('Batch ID: '.$batch->id);
        }

        return 0;
    }
}
