<?php

namespace App\Jobs;

use App\Models\Action;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ReleaseDependantActions implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $action;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Action $action)
    {
        $this->action = $action;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach ($this->action->type->dependentActionTypes as $actionType) {
            // Currently only needed for Journals and already assigned.
            if ($actionType->name == '4LV') {
                continue;
            }
            if (class_basename($this->action->actionable) == 'Item') {
                $parent = $this->action->actionable->parent();
            } else {
                $parent = $this->action->actionable->parent;
            }
            $action = Action::firstOrCreate([
                'action_type_id' => $actionType->id,
                'actionable_type' => get_class($this->action->actionable),
                'actionable_id' => $this->action->actionable->id,
            ], [
                'parent_item_id' => $parent?->id,
            ]);
        }
    }
}
