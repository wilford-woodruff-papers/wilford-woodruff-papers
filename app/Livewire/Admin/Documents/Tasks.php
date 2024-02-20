<?php

namespace App\Livewire\Admin\Documents;

use App\Jobs\AutoPublishDocument;
use App\Jobs\ReleaseDependantActions;
use App\Models\Action;
use App\Models\ActionType;
use App\Models\Item;
use App\Models\Type;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Tasks extends Component
{
    use WithPagination;

    public $actionType;

    public $assignedItems;

    public $search;

    public $type;

    public $types;

    public $actionTypes;

    public $sortBy = 'pcf_unique_id';

    public $sortDirection = 'asc';

    protected $queryString = [
        'sortBy' => ['except' => ''],
        'sortDirection' => ['except' => ''],
        'actionType' => ['except' => ''],
        'search' => ['except' => ''],
        'type' => ['except' => ''],
    ];

    public $typesMap = [
        'Letters' => ['Letters'],
        'Discourses' => ['Discourses'],
        'Journals' => ['Journals', 'Journal Sections'],
        'Additional' => ['Additional', 'Additional Sections'],
        'Autobiographies' => ['Autobiography Sections', 'Autobiographies'],
        'Daybooks' => ['Daybooks', 'Daybook Sections'],
    ];

    public function mount()
    {
        $this->types = Type::query()
            ->whereNull('type_id')
            ->orderBy('name')
            ->get();

        $this->actionTypes = ActionType::query()
            ->where('type', 'Documents')
            ->orderBy('name')
            ->get();
    }

    public function getAssignedItems()
    {
        return Item::query()
            ->whereNotNull('pcf_unique_id')
            ->with([
                'type',
                'pending_actions' => function ($query) {
                    $query->where('assigned_to', auth()->id())
                        ->whereNull('completed_at');
                },
                'pending_actions.type',
            ])
            ->whereHas('pending_actions', function (Builder $query) {
                $query->where('assigned_to', auth()->id())
                    ->whereNull('completed_at');
            })
            ->orWhereHas('pending_page_actions', function (Builder $query) {
                $query->where('assigned_to', auth()->id())
                    ->whereNull('completed_at');
            })
            ->get();
    }

    public function render()
    {
        $this->assignedItems = $this->getAssignedItems();

        $userRoles = auth()->user()->roles;

        $unassignedItems = Item::query()
            ->select('items.*', DB::raw('(SELECT COUNT(*) FROM pages WHERE pages.item_id = items.id) as pages_count'))
            ->whereNotNull('pcf_unique_id')
            ->with([
                'type',
                'unassigned_actions',
                'unassigned_actions.type',
                'unassigned_actions.type.roles',
                'completed_actions',
                'completed_actions.type',
            ])
            ->when(! empty($this->type), function ($query, $type) {
                $query->whereRelation('type', function ($query) {
                    $query->whereIn('name', $this->typesMap[$this->type]);
                });
            })
            ->when($this->search, function ($query, $search) {
                $query->where('items.name', 'LIKE', '%'.$search.'%');
            })
            ->whereHas('actions', function (Builder $query) use ($userRoles) {
                $query->whereNull('assigned_at')
                    ->whereNull('completed_at')
                    ->whereHas('type', function (Builder $query) use ($userRoles) {
                        $query->whereIn('id', ActionType::query()->role($userRoles)->pluck('id')->all());
                    })
                    ->when($this->actionType, function ($query, $actionType) {
                        $query->whereRelation('type', 'id', $actionType);
                    });
            })
            ->whereHas('type', function (Builder $query) use ($userRoles) {
                $query->whereIn('id', Type::query()->role($userRoles)->pluck('id')->all());
            })
            ->orderBy(DB::raw('LENGTH('.$this->sortBy.')'), $this->sortDirection)
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(25);

        return view('livewire.admin.documents.tasks', [
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
            \App\Models\Action::updateOrCreate([
                'actionable_type' => get_class($page),
                'actionable_id' => $page->id,
                'action_type_id' => $action->action_type_id,
            ], [
                'assigned_to' => $user->id,
                'assigned_at' => now(),
            ]);
        });
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
            $item->pages->each(function ($page) use ($user, $action) {
                \App\Models\Action::updateOrCreate([
                    'actionable_type' => get_class($page),
                    'actionable_id' => $page->id,
                    'action_type_id' => $action->action_type_id,
                ], [
                    'completed_by' => $user->id,
                    'completed_at' => now(),
                ]);
            });

            AutoPublishDocument::dispatch($item);
            $this->assignedItems = $this->getAssignedItems();
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

    #[On('reloadTasks')]
    public function reloadTasks()
    {
        $this->render();
    }

    public function applySort($name, $direction)
    {
        $this->sortBy = $name;
        $this->sortDirection = ($direction == 'asc' ? 'desc' : 'asc');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingActionType()
    {
        $this->resetPage();
    }

    public function updatingType()
    {
        $this->resetPage();
    }

    public function updatingPage()
    {
        $this->dispatch('scroll-to-top');
    }
}
