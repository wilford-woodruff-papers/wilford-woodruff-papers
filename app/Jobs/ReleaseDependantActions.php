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
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->action->type->dependentActionTypes as $actionType) {
            Action::firstOrCreate([
                'action_type_id' => $actionType->id,
                'actionable_type' => get_class($this->action->actionable),
                'actionable_id' => $this->action->actionable->id,
                'parent_item_id' => $this->action->actionable->parent()?->id,
            ]);
        }
    }
}
