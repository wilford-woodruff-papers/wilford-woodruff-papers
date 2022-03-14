<?php

namespace App\Console\Commands;

use App\Events\ItemSelectedForImport;
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
            $items = Item::whereEnabled(true)->whereNotNull('ftp_id');
        }else{
            $items = Item::whereId($itemId)->whereNotNull('ftp_id');
        }

        try{
            $items->chunkById(10, function($items){
                $items->each(function($item, $key){
                    ItemSelectedForImport::dispatch($item);
                });
            }, $column = 'id');
        }catch(\Exception $e){
            ray($e->getMessage());
        }



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
