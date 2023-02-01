<?php

namespace App\Console\Commands;

use App\Models\Item;
use Illuminate\Console\Command;

class CacheDates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dates:cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Extract date first date for evey page';

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
        $items->each(function ($item) {
            $dates = collect();
            $item->pages->each(function ($page) use (&$dates) {
                $dates = $dates->concat($page->dates);
            });
            $item->first_date = optional($dates->sortBy('date')->first())->date;
            if ($item->first_date) {
                $item->decade = floor($item->first_date->year / 10) * 10;
                $item->year = $item->first_date->year;
            }
            $item->save();
        });

        $items = Item::has('items')->get();
        $items->each(function ($item) {
            $item->first_date = optional($item->items->sortBy('date')->first())->first_date;
            if ($item->first_date) {
                $item->decade = floor($item->first_date->year / 10) * 10;
                $item->year = $item->first_date->year;
            }
            $item->save();
        });

        logger()->info('Dates Cached: '.now());
    }
}
