<?php

namespace App\Console\Commands;

use App\Models\Item;
use App\Models\Page;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use PHPHtmlParser\Dom;

class Harvest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'harvest';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Harvest FTP';

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
        $response = Http::get( 'https://fromthepage.com/iiif/collection/970' );

        collect(
            data_get( $response, 'manifests', [] )
        )->each(function ($manifest, $key){
            $document = Item::updateOrCreate([
                'ftp_id' => $manifest['@id'],
            ], [
                'name' => $manifest['label'],
            ]);

            $this->info('Imported: ' . $document->name);


            collect(
                Http::get( $manifest['@id'] )->json('sequences.0.canvases', [])
            )->each(function($canvas, $key) use ($manifest){
                // Add or update the page
                $page = Page::updateOrCreate([
                    'item_id' => Item::where('ftp_id', $manifest['@id'])->firstOrFail()->id,
                    'ftp_id' => $canvas['@id'],
                ], [
                    'name' => $canvas['label'],
                    'transcript' => $this->convertSubjectTags(
                        Http::get( data_get( $canvas, 'otherContent.0.@id', '') )->json('resources.0.resource.chars', '')
                    ),
                    'ftp_link' => data_get( $canvas, 'related.0.@id', '' )
                ]);

                // Add image to page
                if( ! $page->hasMedia()
                    && data_get( $canvas, 'images.0.resource.@id', false )
                ){
                    $page->addMediaFromUrl(
                        data_get( $canvas, 'images.0.resource.@id' )
                    )->toMediaCollection();
                }

                $this->info('Imported: ' . $page->name);

            });

            dd('Exit');

        });

        return Command::SUCCESS;
    }

    private function convertSubjectTags($transcript)
    {
        $dom = new Dom;
        $dom->loadStr($transcript);
        $transcript = Str::of($transcript);
        $links = $dom->find('a');
        foreach($links as $link){
            $transcript = $transcript->replace(
                $link->outerHtml(),
                '[['. $link->getAttribute('title') .'|'. $link->innerHtml() .']]'
            );
        }
        return $transcript;
    }
}
