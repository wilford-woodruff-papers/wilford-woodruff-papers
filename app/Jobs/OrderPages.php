<?php

namespace App\Jobs;

use App\Models\Item;
use App\Models\Page;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class OrderPages implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Item $item;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Item $item)
    {
        $this->item = $item;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->item->items->count() == 0) {
            $pageSortColumn = $item->page_sort_column ?? 'id';
            if ($this->item->enabled) {
                $pages = $this->item->pages->sortBy($pageSortColumn);
                $pages->each(function ($page) {
                    $page->parent_item_id = $this->item->parent()->id;
                    $page->type_id = $this->item->parent()->type_id;
                    $page->save();
                });

                Page::setNewOrder($pages->pluck('id')->all());

                $this->item->fresh();
                $pages = $this->item->pages;
                $pages->each(function ($page) {
                    $page->full_name = $this->item->name.': Page'.$page->order;
                    $page->save();
                });
            }
        } else {
            $itemPages = collect([]);
            $this->item->items->sortBy('order')->each(function ($child) use (&$itemPages) {
                $pageSortColumn = $child->page_sort_column ?? 'id';
                $itemPages = $itemPages->concat($child->pages->sortBy($pageSortColumn));
            });
            $itemPages->each(function ($page) {
                $page->parent_item_id = $this->item->parent()->id;
                $page->type_id = $this->item->parent()->type_id;
                $page->save();
            });

            Page::setNewOrder($itemPages->pluck('id')->all());

            $this->item->fresh();
            $pages = $this->item->pages;
            $pages->each(function ($page) {
                $page->full_name = $this->item->name.': Page'.$page->order;
                $page->save();
            });
        }

        logger()->info('Page Order Updated for '.$this->item->name);

        CacheDates::dispatch($this->item);
    }
}
