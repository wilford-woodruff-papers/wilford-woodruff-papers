<?php

namespace App\Jobs;

use App\Models\Item;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AutoPublishDocument implements ShouldQueue
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
        if ($this->item->enabled != true && $this->item->canBePublished()) {
            $this->item->enabled = true;
            $this->item->save();
            info($this->item->id.' was published.');
        } elseif ($this->item->enabled == true && $this->item->canBePublished()) {
            info($this->item->id.' is already published.');
        } else {
            $this->item->enabled = false;
            $this->item->save();
            info($this->item->id.' cannot be published.');
        }

        if (! empty($this->item->item_id)) {
            $parent = $this->item->item;
            if ($parent->parentCanBePublished()) {
                $parent->enabled = true;
                $parent->save();
                info($this->item->id.' was published.');
            } else {
                $parent->enabled = false;
                $parent->save();
                info($this->item->id.' cannot be published.');
            }
        }
    }
}
