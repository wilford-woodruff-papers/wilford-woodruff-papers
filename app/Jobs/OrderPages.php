<?php

namespace App\Jobs;

use App\Models\Item;
use App\Models\Page;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class OrderPages implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $items = Item::doesntHave('items')->get();
        $items->each(function($item){
            if($item->enabled){
                $pages = $item->pages->sortBy('id');
                $pages->each(function($page) use ($item){
                    $page->parent_item_id = $item->parent()->id;
                    $page->type_id = $item->parent()->type_id;
                    $page->save();
                });
                Page::setNewOrder($pages->pluck('id')->all());

                $item->fresh();
                $pages = $item->pages;
                $pages->each(function($page) use ($item){
                    $page->full_name = $item->name . ': Page' . $page->order;
                    $page->save();
                });

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
                $page->type_id = $item->parent()->type_id;
                $page->save();
            });
            //$this->info('Item: ' . $item->id);
            //$this->info(implode(', ', $itemPages->pluck('id')->all()));
            Page::setNewOrder($itemPages->pluck('id')->all());

            $item->fresh();
            $pages = $item->pages;
            $pages->each(function($page) use ($item){
                $page->full_name = $item->name . ': Page' . $page->order;
                $page->save();
            });
        });

        logger()->info('Page Order Updated: ' . now());
    }
}
