<?php

namespace App\Jobs;

use App\Models\Item;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CacheDates implements ShouldQueue
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
