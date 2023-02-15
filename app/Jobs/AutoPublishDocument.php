<?php

namespace App\Jobs;

use App\Models\Item;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

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
            $this->addPublishedTask($this->item);
            info($this->item->id.' was published.');
        } elseif ($this->item->enabled == true && $this->item->canBePublished()) {
            info($this->item->id.' is already published.');
        } else {
            $this->item->enabled = false;
            $this->item->save();
            $this->removePublishedTask($this->item);
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

    private function addPublishedTask($item)
    {
        $actionType = \App\Models\ActionType::firstWhere('name', 'Publish');
        $user = \App\Models\User::firstWhere('email', 'auto@wilfordwoodruffpapers.org');

        DB::transaction(function () use ($item, $actionType, $user) {
            \App\Models\Action::updateOrCreate([
                'actionable_type' => get_class($item),
                'actionable_id' => $item->id,
                'action_type_id' => $actionType->id,
            ], [
                'assigned_to' => $user->id,
                'assigned_at' => $item->actions->firstWhere('action_type_id', 2)->completed_at,
                'completed_by' => $user->id,
                'completed_at' => $item->actions->firstWhere('action_type_id', 2)->completed_at,
            ]);
            foreach ($item->pages as $page) {
                \App\Models\Action::updateOrCreate([
                    'actionable_type' => get_class($page),
                    'actionable_id' => $page->id,
                    'action_type_id' => $actionType->id,
                ], [
                    'assigned_to' => $user->id,
                    'assigned_at' => $item->actions->firstWhere('action_type_id', 2)->completed_at,
                    'completed_by' => $user->id,
                    'completed_at' => $item->actions->firstWhere('action_type_id', 2)->completed_at,
                ]);
            }
        });
    }

    private function removePublishedTask($item)
    {
        $actionType = \App\Models\ActionType::firstWhere('name', 'Publish');
        $user = \App\Models\User::firstWhere('email', 'auto@wilfordwoodruffpapers.org');

        DB::transaction(function () use ($item, $actionType, $user) {
            \App\Models\Action::updateOrCreate([
                'actionable_type' => get_class($item),
                'actionable_id' => $item->id,
                'action_type_id' => $actionType->id,
            ], [
                'assigned_to' => $user->id,
                'assigned_at' => $item->actions->firstWhere('action_type_id', 2)->completed_at,
                'completed_by' => null,
                'completed_at' => null,
            ]);
            foreach ($item->pages as $page) {
                \App\Models\Action::updateOrCreate([
                    'actionable_type' => get_class($page),
                    'actionable_id' => $page->id,
                    'action_type_id' => $actionType->id,
                ], [
                    'assigned_to' => $user->id,
                    'assigned_at' => $item->actions->firstWhere('action_type_id', 2)->completed_at,
                    'completed_by' => null,
                    'completed_at' => null,
                ]);
            }
        });
    }
}
