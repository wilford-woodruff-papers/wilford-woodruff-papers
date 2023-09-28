<?php

namespace App\Jobs;

use App\Models\Item;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CalculateFirstDateForPages implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Item $item;

    public $timeout = 600;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Item $item)
    {
        //
        $this->item = $item;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if (! empty($this->batch()) && $this->batch()->cancelled()) {
            // Determine if the batch has been cancelled...
            return;
        }

        $firstDateCarry = null;

        foreach ($this->item->pages as $page) {
            if (empty($firstDate = $page->taggedDates()->first()?->date)) {
                $firstDate = $firstDateCarry;
            }
            //info($page->name.': '.$firstDate);
            $page->first_date = $firstDate;
            $page->save();

            $firstDateCarry = $firstDate;
        }
    }
}
