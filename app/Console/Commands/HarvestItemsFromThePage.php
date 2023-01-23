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
        $countWithPCFID = 0;
        $countWithoutPCFID = 0;
        foreach ($manifests as $key => $item) {
            if (data_get($item, 'metadata.0.label') == 'dc:source') {
                $identifier = data_get($item, 'metadata.0.value');
                $prefix = str($identifier)->before('-')->toString();
                $uniqueId = str($identifier)->after('-')->toString();
                $document = Document::query()
                    ->where('pcf_unique_id_prefix', $prefix)
                    ->where('pcf_unique_id', $uniqueId)
                    ->first();
                $countWithPCFID = $countWithPCFID + 1;
            } else {
                $document = Document::query()
                    ->where('ftp_id', $item['@id'])
                    ->first();
                $countWithoutPCFID = $countWithoutPCFID + 1;
            }

            if (empty($document)) {
                $document = new Document();

                $identifier = data_get($item, 'metadata.0.value');
                $prefix = str($identifier)->before('-')->toString();
                $uniqueId = str($identifier)->after('-')->toString();

                if (! empty($uniqueId)) {
                    $document->pcf_unique_id_prefix = $prefix;
                    $document->pcf_unique_id = $uniqueId;
                } else {
                    continue;
                }
            }

            $document->name = $item['label'];

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

        info("Imported $countWithPCFID documents with PCF ID");
        info("Imported $countWithoutPCFID documents without PCF ID");
        info("Imported $count documents");

        return 0;
    }
}
