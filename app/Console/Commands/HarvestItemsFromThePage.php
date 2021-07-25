<?php

namespace App\Console\Commands;

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
        $response = Http::get('https://fromthepage.com/iiif/collection/970');

        $manifests = $response->json()['manifests'];

        foreach($manifests as $key => $item){
            $document = Item::updateOrCreate([
                'ftp_id' => $item['@id'],
            ], [
                'name' => $item['label'],
            ]);
            $document->touch();
        };

        return 0;
    }
}
