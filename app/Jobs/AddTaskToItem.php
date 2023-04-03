<?php

namespace App\Jobs;

use App\Models\Action;
use App\Models\ActionType;
use App\Models\Item;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AddTaskToItem implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Item $item;

    public $taskName;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Item $item, $taskName = 'Transcription')
    {
        $this->item = $item;
        $this->taskName = $taskName;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $actionType = ActionType::firstWhere('name', $this->taskName);

        if (class_basename($this->item) == 'Item') {
            $parent = $this->item->parent();
        } else {
            $parent = $this->item->parent;
        }

        $action = Action::firstOrCreate([
            'action_type_id' => $actionType->id,
            'actionable_type' => get_class($this->item),
            'actionable_id' => $this->item->id,
        ], [
            'parent_item_id' => $parent?->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
