<?php

namespace App\Console\Commands;

use App\Events\ItemSelectedForImport;
use App\Jobs\ImportItemFromFtp;
use App\Models\Date;
use App\Models\Item;
use App\Models\Page;
use App\Models\Subject;
use Illuminate\Bus\Batch;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use PHPHtmlParser\Dom;

class HarvestPagesFromThePage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:pages {item?} {--enable=false}';

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
     *
     * @return int
     */
    public function handle()
    {
        $items = Item::query()
                        ->whereEnabled(true)
                        ->whereNotNull('ftp_id');

        if(! empty($itemId = $this->argument('item'))){
            $items = $items->whereId($itemId);
        }

        $items = $items->get();
        $jobs = [];
        foreach($items as $item){
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
            ->name('Import Pages')
            ->allowsFailures()
            ->dispatch();

        $this->info('Batch ID: ' . $batch->id);

        /*try{
            $items->chunkById(10, function($items){
                $items->each(function($item, $key){
                    // ItemSelectedForImport::dispatch($item);
                        $response = Http::get($item->ftp_id);
                        $canvases = $response->json('sequences.0.canvases');
                        if(! empty($canvases)){

                            foreach($canvases as $key => $canvas){

                                $page = Page::updateOrCreate([
                                    'item_id' => $item->id,
                                    'ftp_id' => $canvas['@id'],
                                ], [
                                    'name' => $canvas['label'],
                                    'transcript' => $this->convertSubjectTags(
                                        ( array_key_exists('otherContent', $canvas) )
                                            ? Http::get($canvas['otherContent'][0]['@id'])->json('resources.0.resource.chars')
                                            : '' ),
                                    'ftp_link' => ( array_key_exists('related', $canvas) )
                                        ? $canvas['related'][0]['@id']
                                        : ''
                                ]);

                                if(! $page->hasMedia()){
                                    $page->clearMediaCollection();

                                    if(! empty($canvas['images'][0]['resource']['@id'])){
                                        $page->addMediaFromUrl($canvas['images'][0]['resource']['@id'])->toMediaCollection();
                                    }
                                }


                                $page->subjects()->detach();

                                $subjects = [];
                                Str::of($page->transcript)->replaceMatches('/(?:\[\[)(.*?)(?:\]\])/', function ($match) use (&$subjects) {
                                    $subjects[] = Str::of($match[0])->trim('[[]]')->explode('|')->first();
                                    return '[['.$match[0].']]';
                                });
                                foreach($subjects as $subject){
                                    $subject = Subject::firstOrCreate([
                                        'name' => $subject,
                                    ]);
                                    $subject->enabled = 1;
                                    $subject->save();
                                    $page->subjects()->syncWithoutDetaching($subject->id);
                                }

                                $page->dates()->delete();

                                $dates = $this->extractDates($page->transcript);

                                foreach($dates as $date){
                                    try{
                                        $d = new Date;
                                        $d->date = $date;
                                        $page->dates()->save($d);
                                    }catch(\Exception $e){
                                        logger()->error($e->getMessage());
                                    }
                                }

                                unset($page);
                            }
                        }

                    $item->imported_at = now('America/Denver');
                    $item->save();
                });
            }, $column = 'id');

            Artisan::call('pages:order');
            Artisan::call('dates:cache');
        }catch(\Exception $e){
            ray($e->getMessage());
        }
        */


        return 0;
    }

    private function convertSubjectTags($transcript)
    {
        $dom = new Dom;
        $dom->loadStr($transcript);
        $transcript = Str::of($transcript);
        $links = $dom->find('a');
        foreach($links as $link){
            //dd($link->outerHtml(), $link->getAttribute('title'), $link->innerHtml());
            $transcript = $transcript->replace($link->outerHtml(), '[['. html_entity_decode($link->getAttribute('title')) .'|'. $link->innerHtml() .']]');
        }
        return $transcript;
    }

    private function extractDates($transcript){
        $dates = [];
        $dom = new Dom;
        $dom->loadStr($transcript);
        $dateNodes = $dom->find('date');
        foreach ($dateNodes as $node){
            $dates[] = $node->getAttribute('when');
        }

        return $dates;
    }
}
