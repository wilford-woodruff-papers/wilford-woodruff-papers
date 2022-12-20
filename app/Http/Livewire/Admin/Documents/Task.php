<?php

namespace App\Http\Livewire\Admin\Documents;

use App\Jobs\ReleaseDependantActions;
use App\Models\Action;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Task extends Component
{
    public $item;

    public $show = false;

    public function mount($item)
    {
        $this->item = $item;
    }

    public function render()
    {
        $this->item->loadMissing(
            'pending_actions',
            'pending_page_actions',
            'pending_page_actions.type',
        );
        $this->item->loadCount(
            'pending_page_actions',
        );
        if ($this->show) {
            $this->item->loadMissing(
                'page_actions',
                'page_actions.finisher',
                'page_actions.type',
                'pending_page_actions.actionable.completed_actions.type',
            );
        }

        return view('livewire.admin.documents.task');
    }

    public function markActionComplete($actionId)
    {
        $user = Auth::user();

        $action = Action::find($actionId);
        $action->completed_at = now();
        $action->completed_by = $user->id;
        $action->save();

        ReleaseDependantActions::dispatch($action);

        if ($action->actionable_type == Item::class) {
            $item = $action->actionable;
            $item->pending_page_actions->where('action_type_id', $action->action_type_id)->each(function ($action) use ($user) {
                $action->completed_at = now();
                $action->completed_by = $user->id;
                $action->save();

                ReleaseDependantActions::dispatch($action);
            });
        }

        $this->item->refresh();
    }

    public function markActionInComplete($actionId)
    {
        $user = Auth::user();

        $action = Action::find($actionId);
        $action->completed_at = null;
        $action->completed_by = null;
        $action->save();

        $this->item->refresh();
    }
}
