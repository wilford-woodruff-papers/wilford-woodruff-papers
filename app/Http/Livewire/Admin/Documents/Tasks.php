<?php

namespace App\Http\Livewire\Admin\Documents;

use App\Models\Action;
use App\Models\ActionType;
use App\Models\Item;
use App\Models\Type;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Tasks extends Component
{
    public $search;

    public $type;

    public $sortBy = 'pcf_unique_id';

    public $sortDirection = 'asc';

    public function render()
    {
        $assignedItems = Item::query()
            ->with(
                'pending_actions',
                'pending_actions.type',
            )
            ->whereHas('pending_actions', function (Builder $query) {
                $query->where('assigned_to', auth()->id())
                    ->whereNull('completed_at');
            })
            ->orWhereHas('pending_page_actions', function (Builder $query) {
                $query->where('assigned_to', auth()->id())
                    ->whereNull('completed_at');
            })
            ->get();

        $userRoles = auth()->user()->roles;

        $unassignedItems = Item::query()
            ->select('items.*', DB::raw('(SELECT COUNT(*) FROM pages WHERE pages.item_id = items.id) as pages_count'))
            ->with(
                'unassigned_actions',
                'unassigned_actions.type',
                'unassigned_actions.type.roles',
                'completed_actions',
                'completed_actions.type',
            )
            ->when($this->type, function ($query, $type) {
                $query->where('type_id', $type);
            })
            ->when($this->search, function ($query, $search) {
                $query->where('items.name', 'LIKE', '%'.$search.'%');
            })
            ->whereHas('actions', function (Builder $query) use ($userRoles) {
                $query->whereNull('assigned_at')
                    ->whereNull('completed_at')
                    ->whereHas('type', function (Builder $query) use ($userRoles) {
                        $query->whereIn('id', ActionType::query()->role($userRoles)->pluck('id')->all());
                    });
            })->whereHas('type', function (Builder $query) use ($userRoles) {
                $query->whereIn('id', Type::query()->role($userRoles)->pluck('id')->all());
            })
            ->orderBy(DB::raw('LENGTH('.$this->sortBy.')'), $this->sortDirection)
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(15);

        return view('livewire.admin.documents.tasks', [
            'assignedItems' => $assignedItems,
            'unassignedItems' => $unassignedItems,
            'userRoles' => $userRoles,
        ]);
    }

    public function claimItemAction($actionId)
    {
        $user = Auth::user();

        $action = Action::find($actionId);
        $action->assigned_at = now();
        $user->tasks()->save($action);

        $item = $action->actionable;
        $item->pages->each(function ($page) use ($user, $action) {
            $user->tasks()->save(Action::create([
                'actionable_type' => get_class($page),
                'actionable_id' => $page->id,
                'action_type_id' => $action->action_type_id,
                'assigned_at' => now(),
            ]));
        });
    }

    public function markActionComplete($actionId)
    {
        $user = Auth::user();

        $action = Action::find($actionId);
        $action->completed_at = now();
        $action->completed_by = $user->id;
        $action->save();

        if ($action->actionable_type == Item::class) {
            $item = $action->actionable;
            $item->pending_page_actions->where('action_type_id', $action->action_type_id)->each(function ($action) use ($user) {
                $action->completed_at = now();
                $action->completed_by = $user->id;
                $action->save();
            });
        }

        $this->reload();
    }

    public function markActionInComplete($actionId)
    {
        $user = Auth::user();

        $action = Action::find($actionId);
        $action->completed_at = null;
        $action->completed_by = null;
        $action->save();
    }

    public function applySort($name, $direction)
    {
        $this->sortBy = $name;
        $this->sortDirection = ($direction == 'asc' ? 'desc' : 'asc');
    }
}
