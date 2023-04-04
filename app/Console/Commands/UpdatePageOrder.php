<?php

namespace App\Console\Commands;

use App\Models\Item;
use App\Models\Page;
use Illuminate\Console\Command;

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
     */
    public function handle(): int
    {
        $items = Item::query()
                        ->whereNull('item_id')
                        ->doesntHave('items')
                        ->get();
        $items->each(function ($item) {
            $pageSortColumn = $item->page_sort_column ?? 'id';
            if ($item->enabled) {
                $pages = $item->pages->sortBy($pageSortColumn);
                $pages->each(function ($page) use ($item) {
                    $page->parent_item_id = $item->parent()->id;
                    $page->type_id = $item->parent()->type_id;
                    $page->save();
                });
                Page::setNewOrder($pages->pluck('id')->all());

                $item->fresh();
                $pages = $item->pages;
                $pages->each(function ($page) use ($item) {
                    $page->full_name = $item->name.': Page'.$page->order;
                    $page->save();
                });
            }
        });

        $items = Item::has('items')->get();
        $items->each(function ($item) {
            $itemPages = collect([]);
            $item->items->sortBy('order')->each(function ($child) use (&$itemPages) {
                $pageSortColumn = $child->page_sort_column ?? 'id';
                $itemPages = $itemPages->concat($child->pages->sortBy($pageSortColumn));
            });
            $itemPages->each(function ($page) use ($item) {
                $page->parent_item_id = $item->parent()->id;
                $page->type_id = $item->parent()->type_id;
                $page->save();
            });
            $this->info('Item: '.$item->id);
            $this->info(implode(', ', $itemPages->pluck('id')->all()));
            Page::setNewOrder($itemPages->pluck('id')->all());

            $item->fresh();
            $pages = $item->pages;
            $pages->each(function ($page) use ($item) {
                $page->full_name = $item->name.': Page '.$page->order;
                $page->save();
            });
        });
        logger()->info('Page Order Updated: '.now());

        return Command::SUCCESS;
    }
}
