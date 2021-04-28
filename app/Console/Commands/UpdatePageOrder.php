<?php

namespace App\Console\Commands;

use App\Models\Item;
use App\Models\Page;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;

class UpdatePageOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pages:order';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update parent IDs and sort order';

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

        $items = Item::doesntHave('items')->get();
        $items->each(function($item){
            if($item->enabled){
                $pages = $item->pages->sortBy('id');
                $pages->each(function($page) use ($item){
                    $page->parent_item_id = $item->parent()->id;
                    $page->save();
                });
                Page::setNewOrder($pages->pluck('id')->all());
            }
        });

        $items = Item::has('items')->get();
        $items->each(function($item){
            $itemPages = collect([]);
            $item->items->sortBy('order')->each(function($child) use (&$itemPages){
                $itemPages = $itemPages->concat($child->pages);
            });
            $itemPages->each(function($page) use ($item){
                $page->parent_item_id = $item->parent()->id;
                $page->save();
            });
            $this->info('Item: ' . $item->id);
            $this->info(implode(', ', $itemPages->pluck('id')->all()));
            Page::setNewOrder($itemPages->pluck('id')->all());
        });

    }
}
