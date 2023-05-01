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
     */
    public function handle(): void
    {
        if ($this->item->items->count() == 0) {
            $dates = collect();
            $this->item->pages->each(function ($page) use (&$dates) {
                $dates = $dates->concat($page->dates);
            });
            $this->item->first_date = optional($dates->sortBy('date')->first())->date;
        } else {
            $this->item->first_date = optional($this->item->items->sortBy('date')->first())->first_date;
        }

        if ($this->item->first_date) {
            $this->item->decade = floor($this->item->first_date->year / 10) * 10;
            $this->item->year = $this->item->first_date->year;
        }

        $this->item->save();

        logger()->info('Dates Cached for '.$this->item->name);
    }
}
