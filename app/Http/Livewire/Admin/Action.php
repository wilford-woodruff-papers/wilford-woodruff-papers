<?php

namespace App\Http\Livewire\Admin;

use App\Jobs\AutoPublishDocument;
use App\Jobs\ReleaseDependantActions;
use App\Models\Item;
use App\Models\Page;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class Action extends Component
{
    public \App\Models\Action $action;

    public $assignee;

    public $finisher;

    public $show = true;

    public $users;

    public function mount()
    {
        $this->users = Cache::remember('users', 60, function () {
            return User::query()
                ->select(['id', 'name'])
                ->role('Editor')
                ->orderBy('users.name')
                ->get();
        });
    }

    public function render()
    {
        return view('livewire.admin.action');
    }

    public function updatedAssignee($value)
    {
        $this->action->assigned_to = $value;
        $this->action->assigned_at = now();
        $this->action->save();

        $user = User::find($value);

        if ($this->action->actionable_type == Item::class) {
            $item = $this->action->actionable;
            $item->load('pages');
            $item->pages()->each(function ($page) use ($user) {
                $user->tasks()->save(\App\Models\Action::create([
                    'actionable_type' => get_class($page),
                    'actionable_id' => $page->id,
                    'action_type_id' => $this->action->action_type_id,
                    'assigned_at' => now(),
                ]));
            });
        }

        $this->action = $this->action->fresh(['assignee', 'finisher']);
        activity('activity')
            ->on(Page::find($this->action->actionable_id))
            ->event('assigned')
            ->log($this->action->description.' assigned to <span class="user">'.$this->action->assignee->name.'</span>');
    }

    public function deleteAction()
    {
        $this->action->delete();

        $this->show = false;
    }

    public function updatedFinisher($value)
    {
        if (empty($this->action->assigned_to)) {
            $this->updatedAssignee($value);
        }
        $this->action->completed_by = $value;
        $this->action->completed_at = now();
        $this->action->save();

        ReleaseDependantActions::dispatch($this->action);

        if ($this->action->actionable_type == Item::class) {
            $item = $this->action->actionable;
            AutoPublishDocument::dispatch($item);
        }

        // TODO: I think I need to update this so that if it's an item, all pages are also marked as complete.

        $this->action = $this->action->fresh(['assignee', 'finisher']);
        activity('activity')
            ->on(Page::find($this->action->actionable_id))
            ->event('completed')
            ->log($this->action->description.' completed by <span class="user">'.$this->action->finisher->name.'</span>');
    }

    public function unassignAction($actionId)
    {
        $this->action->assigned_to = null;
        $this->action->assigned_at = null;
        $this->action->save();
        $this->action = $this->action->fresh(['assignee', 'finisher']);

        if ($this->action->actionable_type == Item::class) {
            $this->action->actionable->pages()->each(function ($page) {
                foreach ($page->pending_assigned_actions()->where('action_type_id', $this->action->action_type_id)->get() as $task) {
                    $task->assigned_to = null;
                    $task->assigned_at = null;
                    $task->save();
                }
            });

            $item = $this->action->actionable;
            AutoPublishDocument::dispatch($item);
        }
//
//        activity('activity')
//            ->on(Page::find($this->action->actionable_id))
//            ->event('completed')
//            ->log($this->action->description.' unnassigned by <span class="user">'.auth()->user()->name.'</span>');
    }

    public function uncompleteAction($actionId)
    {
        $this->action->completed_by = null;
        $this->action->completed_at = null;
        $this->action->save();
        $this->action = $this->action->fresh(['assignee', 'finisher']);

        if ($this->action->actionable_type == Item::class) {
            $this->action->actionable->pages()->each(function ($page) {
                foreach ($page->pending_assigned_actions()->where('action_type_id', $this->action->action_type_id)->get() as $task) {
                    $task->completed_by = null;
                    $task->completed_at = null;
                    $task->save();
                }
            });

            $item = $this->action->actionable;
            AutoPublishDocument::dispatch($item);
        }
//
//        activity('activity')
//            ->on(Page::find($this->action->actionable_id))
//            ->event('completed')
//            ->log($this->action->description.' unnassigned by <span class="user">'.auth()->user()->name.'</span>');
    }
}
