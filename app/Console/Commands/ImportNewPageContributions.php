<?php

namespace App\Console\Commands;

use App\Models\Item;
use Illuminate\Console\Command;
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
        $response = Http::get('https://fromthepage.com/iiif/contributions/woodruff/2022-02-21T23:53:03+00:00/2022-03-22T23:53:03+00:00');

        $manifests = collect($response->json('manifests', []));

        $items = Item::query()
            ->where('enabled', 1)
            ->whereIn('ftp_id', $manifests->pluck('@id'))
            ->get();

        ray($items);

        return 0;
    }
}
