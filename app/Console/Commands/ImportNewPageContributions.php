<?php

namespace App\Console\Commands;

use App\Jobs\ImportItemFromFtp;
use App\Models\Item;
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
    public function handle(): int
    {
        // Todo: Set start and end times
        $start = now('America/Denver')->subHours(24)->tz('UTC');
        $end = now('America/Denver')->tz('UTC');
        $url = 'https://fromthepage.com/iiif/contributions/woodruff/'.$start->toIso8601String().'/'.$end->toIso8601String();
        logger()->info('Getting new contributions from: '.$url);
        $response = Http::timeout(60)
            ->retry(3, 500)
            ->get($url);

        $manifests = collect($response->json('manifests', []));

        $items = Item::query()
            ->where('enabled', 1)
            ->whereIn('ftp_id', $manifests->pluck('@id'))
            ->get();

        if ($items->count() > 0) {
            $jobs = [];
            foreach ($items as $item) {
                $jobs[] = new ImportItemFromFtp($item);
                logger()->info('Queuing: '.$item->name);
            }

            $batch = Bus::batch($jobs)
                ->onQueue('pages')
                ->name('Import New Pages Contributions')
                ->allowFailures()
                ->dispatch();

            $this->info('Batch ID: '.$batch->id);
        }

        return 0;
    }
}
