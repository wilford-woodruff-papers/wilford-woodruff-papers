<?php

namespace App\Console\Commands;

use App\Models\Document;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class HarvestItemsFromThePage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:items';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import items from From the Page';

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
        $response = Http::timeout(120)->get('https://fromthepage.com/iiif/collection/970');

        $manifests = $response->json()['manifests'];
        $count = 0;
        foreach ($manifests as $key => $item) {
            $document = Document::updateOrCreate([
                'ftp_id' => $item['@id'],
            ], [
                'name' => $item['label'],
            ]);
            if (data_get($item, 'service.pctComplete', 0) == 100.0) {
                $document->enabled = true;
            }

            if (empty($document->ftp_slug)) {
                $response = Http::timeout(30)->get($item['@id']);
                $document->ftp_slug = str($response->json('related.0.@id'))->afterLast('/');
            }

            $document->save();

            $count = $count + 1;
        }
        $this->info("Imported $count documents");

        return 0;
    }
}
