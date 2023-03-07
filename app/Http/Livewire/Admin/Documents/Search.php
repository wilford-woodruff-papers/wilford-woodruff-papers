<?php

namespace App\Http\Livewire\Admin\Documents;

use App\Http\Livewire\DataTable\WithBulkActions;
use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Http\Livewire\DataTable\WithSorting;
use App\Models\ActionType;
use App\Models\Item;
use App\Models\TargetPublishDate;
use App\Models\Template;
use App\Models\Type;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class Search extends Component
{
    use WithPerPagePagination, WithSorting, WithBulkActions, WithCachedRows;

    public $showDeleteModal = false;

    public $showEditModal = false;

    public $showFilters = true;

    public $targetDates = [];

    public $taskTypes = [];

    public $types = [];

    public $filters = [
        'search' => '',
        'status' => '',
        'type' => '',
        'needs' => '',
        'date-min' => '',
        'date-max' => '',
    ];

    protected $queryString = [
        'sorts',
        'filters' => ['except' => ''],
    ];

    protected $listeners = [
        'refreshQuotes' => '$refresh',
    ];

    public function mount()
    {
        $this->targetDates = TargetPublishDate::query()
            ->where('publish_at', '>', now())
            ->orderBy('publish_at', 'ASC')
            ->limit(3)
            ->get();

        $this->taskTypes = ActionType::query()
            ->for('Documents')
            ->ordered()
            ->get();

        $this->types = Type::query()
            ->whereNull('type_id')
            ->orderBy('name')
            ->get();

        //$this->filters['date-min'] = request('filters.date-min') ?? '1807-03-01';
        //$this->filters['date-max'] = request('filters.date-max') ?? '1898-09-02';
    }

    public function updatedFilters()
    {
        $this->resetPage();
    }

    public function exportSelected()
    {
        return response()->streamDownload(function () {
            echo $this->selectedRowsQuery->toCsv();
        }, 'documents.csv');
    }

    public function deleteSelected()
    {
        $deleteCount = $this->selectedRowsQuery->count();

        $this->selectedRowsQuery->delete();

        $this->showDeleteModal = false;

        $this->notify('You\'ve deleted '.$deleteCount.' documents');
    }

    public function toggleShowFilters()
    {
        $this->useCachedRows();

        $this->showFilters = ! $this->showFilters;
    }

    public function resetFilters()
    {
        $this->reset('filters');
        $this->resetPage();
    }

    public function getRowsQueryProperty()
    {
        $query = Item::query()
            ->with('type', 'target_publish_dates', 'active_target_publish_date', 'actions')
            ->whereNotNull('type_id')
            ->when(array_key_exists('search', $this->filters) && $this->filters['search'], fn ($query, $search) => $query->where('name', 'like', '%'.$this->filters['search'].'%'))
            ->when(array_key_exists('status', $this->filters) && $this->filters['status'], fn ($query, $status) => $query->where('enabled', $this->filters['status'] == 'on' ? 1 : 0))
            ->when(array_key_exists('needs', $this->filters) && $this->filters['needs'], function ($query, $status) {
                $action = ActionType::query()->firstWhere('id', $this->filters['needs']);
                $query = $query->whereNotNull('ftp_slug')
                                ->whereNotNull('pcf_unique_id');
                if (! empty($action->action_type_id)) {
                    $query->where(function (Builder $query) use ($action) {
                        $query->whereHas('actions.type', function (Builder $query) use ($action) {
                            $query->where('action_types.id', $action->action_type_id)
                                ->whereNotNull('completed_at');
                        })
                        ->whereDoesntHave('actions.type', function (Builder $query) {
                            $query->where('action_types.id', $this->filters['needs']);
                        })
                        ->whereDoesntHave('items');
                    });
                } else {
                    $query->whereDoesntHave('actions.type', function (Builder $query) {
                        $query->where('action_types.id', $this->filters['needs']);
                    });
                }
            })
            ->when(array_key_exists('type', $this->filters) && $this->filters['type'], function ($query) {
                $type = Type::query()->where('id', $this->filters['type'])->first();
                $types = [$type->id];
                if ($subType = Type::query()->where('type_id', $type->id)->first()) {
                    $types[] = $subType->id;
                }
                $query->whereIn('type_id', $types);
            });

        return $this->applySorting($query);
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function render()
    {
        $columns = [];
        if (array_key_exists('type', $this->filters) && ! empty($this->filters['type'])) {
            $columns = Template::query()->firstWhere('type_id', $this->filters['type'])?->properties ?? [];
        }

        return view('livewire.admin.documents.search', [
            'items' => $this->rows,
            'columns' => $columns,
        ])
            ->layout('layouts.admin');
    }

    public function flagForPublication($itemId, $dateId)
    {
        $item = Item::find($itemId);
        $targetDate = TargetPublishDate::find($dateId);
        $item->target_publish_dates()->toggle($targetDate);
    }

    public function addTasks($itemId, $taskTypeId)
    {
        $item = Item::find($itemId);
        if (
            $item->actions()
                ->where('action_type_id', $taskTypeId)
                ->where(function (Builder $query) {
                    $query->whereNull('assigned_at')
                        ->orWhereNull('completed_at');
                })
                ->first()
        ) {
        } else {
            $actionType = ActionType::find($taskTypeId);
            $item->actions()->create([
                'action_type_id' => $actionType->id,
            ]);
        }
    }

    public function addTasksInBulk($taskTypeId)
    {
        foreach ($this->selected as $row) {
            $this->addTasks($row, $taskTypeId);
        }
    }
}
