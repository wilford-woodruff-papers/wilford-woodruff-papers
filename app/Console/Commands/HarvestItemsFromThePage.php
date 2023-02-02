<?php

namespace App\Console\Commands;

use App\Jobs\AddTaskToItem;
use App\Jobs\ImportItemFromFtp;
use App\Models\Item;
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
                // If the item has been assigned Unique ID in FTP then use it to look up the item
                $identifier = data_get($item, 'metadata.0.value');
                $prefix = str($identifier)->before('-')->toString();
                $uniqueId = str($identifier)->after('-')->toString();
                $document = Item::query()
                    ->where('pcf_unique_id_prefix', $prefix)
                    ->where('pcf_unique_id', $uniqueId)
                    ->first();
                $countWithPCFID = $countWithPCFID + 1;
            } else {
                $document = Item::query()
                    ->where('ftp_id', $item['@id'])
                    ->first();
                $countWithoutPCFID = $countWithoutPCFID + 1;
            }

            if (empty($document)) {
                $document = new Item();
                $document->parental_type = 'App\Models\Document';

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

            if (! empty($document)) {
                $document->name = $item['label'];

                if (empty($document->ftp_id) || ($document->ftp_id !== $item['@id'])) {
                    $document->ftp_id = $item['@id'];
                    $response = Http::timeout(30)->get($item['@id']);
                    $document->ftp_slug = str($response->json('related.0.@id'))->afterLast('/');
                    $document->save();
                    info($document->name.' was replaced in FTP. Updating Pages.');
                    $document->pages()->delete();
                    ImportItemFromFtp::dispatch($document, false, true);
                }

                if (data_get($item, 'service.pctComplete', 0) == 100.0) {
                    $document->enabled = true;
                }

                if (empty($document->ftp_slug)) {
                    $response = Http::timeout(30)->get($item['@id']);
                    $document->ftp_slug = str($response->json('related.0.@id'))->afterLast('/');
                }

                $document->save();

                if (! in_array($item['label'], [
                    '2LV Training',
                    'Test Pages Set 1, Work 1',
                    'Test Work for Biographical Research',
                    'Test Work for Jon -- exporting',
                    'Testing image upload with JPG, testing nova status',
                    'A SAMPLE TRANSCRIBED DOCUMENT',
                    '32008275',
                ])) {
                    AddTaskToItem::dispatch($document, 'Transcription');
                }
            }

            $count = $count + 1;
            unset($document);
        }

        info("Imported $countWithPCFID documents with PCF ID");
        info("Imported $countWithoutPCFID documents without PCF ID");
        info("Imported $count documents");

        return 0;
    }
}
