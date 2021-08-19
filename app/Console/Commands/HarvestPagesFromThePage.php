<?php

namespace App\Console\Commands;

use App\Models\Date;
use App\Models\Item;
use App\Models\Page;
use App\Models\Subject;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;
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
        if(empty($itemId = $this->argument('item'))){
            $items = Item::whereEnabled(true)->whereNotNull('ftp_id')->orderBy('id', 'ASC');
        }else{
            $items = Item::whereId($itemId)->whereNotNull('ftp_id');
        }


        $items->chunkById(10, function($items){
            $items->each(function($item, $key){

                try{
                    logger()->info($item->id);
                    logger()->info($item->name);
                    logger()->info($item->ftp_id);
                    $response = Http::withOptions([
                        'stream' => true,
                        'version' => '1.0',
                    ])->get($item->ftp_id);
                    $canvases = $response->json('sequences.0.canvases');
                    if(! empty($canvases)){
                        logger()->info("Canvases: ");
                        foreach($canvases as $key => $canvas){
                            logger()->info($canvas['@id']);
                            $page = Page::updateOrCreate([
                                'item_id' => $item->id,
                                'ftp_id' => $canvas['@id'],
                            ], [
                                'name' => $canvas['label'],
                                'transcript' => $this->convertSubjectTags(
                                    ( array_key_exists('otherContent', $canvas) )
                                        ? Http::withOptions([
                                                'stream' => true,
                                                'version' => '1.0',
                                            ])->get($canvas['otherContent'][0]['@id'])->json('resources.0.resource.chars')
                                        : '' ),
                                'ftp_link' => ( array_key_exists('related', $canvas) )
                                    ? $canvas['related'][0]['@id']
                                    : ''
                            ]);
                            logger()->info('Clear media');
                            $page->clearMediaCollection();
                            logger()->info($canvas['images'][0]['resource']['@id']);
                            logger()->info(route('pages.show', ['item' => $item, 'page' => $page]));

                            if(! empty($canvas['images'][0]['resource']['@id'])){
                                $page->addMediaFromUrl($canvas['images'][0]['resource']['@id'])->toMediaCollection();
                            }

                            $page->subjects()->detach();
                            logger()->info('Subjects');
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
                            logger()->info('Dates');

                            $dates = $this->extractDates($page->transcript);

                            foreach($dates as $date){
                                try{
                                    $d = new Date;
                                    $d->date = $date;
                                    $page->dates()->save($d);
                                }catch(\Exception $e){
                                    logger()->error($e->getMessage());
                                    logger()->info($page->id);
                                }
                            }
                            logger()->info("Done");
                            unset($page);
                        }
                        if($this->option('enable') == true){
                            $item->enabled = 1;
                            $item->save();
                        }
                    }
                } catch (\Exception $e) {
                    logger()->error($e->getMessage());
                }
            });
        }, $column = 'id');

        Artisan::call('pages:order');

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
            $transcript = $transcript->replace($link->outerHtml(), '[['. $link->getAttribute('title') .'|'. $link->innerHtml() .']]');
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
