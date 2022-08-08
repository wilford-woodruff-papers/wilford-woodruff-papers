<?php

namespace App\Http\Livewire\Admin\Documents;

use App\Http\Livewire\DataTable\WithBulkActions;
use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Http\Livewire\DataTable\WithSorting;
use App\Models\Action;
use App\Models\ActionType;
use App\Models\Item;
use App\Models\TargetPublishDate;
use Livewire\Component;

class Dashboard extends Component
{
    use WithPerPagePagination, WithSorting, WithBulkActions, WithCachedRows;

    public $showDeleteModal = false;

    public $showEditModal = false;

    public $showFilters = true;

    public $targetDates = [];

    public $taskTypes= [];

    public $filters = [
        'search' => '',
        'status' => '',
        'type' => '',
        'date-min' => '',
        'date-max' => '',
    ];

    protected $queryString = ['sorts'];

    protected $listeners = ['refreshQuotes' => '$refresh'];

    public function mount() {
        $this->targetDates = TargetPublishDate::query()
            ->where('publish_at', '>', now())
            ->orderBy('publish_at', 'ASC')
            ->limit(3)
            ->get();

        $this->taskTypes = ActionType::for('Documents')->ordered()->get();
    }

    public function updatedFilters() {
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

    public function resetFilters() {
        $this->reset('filters');
    }

    public function getRowsQueryProperty()
    {
        $query = Item::query()
            ->with('type', 'target_publish_dates', 'active_target_publish_date', 'actions')
            ->when($this->filters['search'], fn($query, $search) => $query->where('name', 'like', '%'.$search.'%'))
            ->when($this->filters['status'], fn($query, $status) => $query->where('enabled', $status == 'on' ? 1 : 0))
            ->when($this->filters['type'], fn($query, $type) => $query->where('type_id', $type));

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
        return view('livewire.admin.documents.dashboard', [
            'items' => $this->rows,
        ]);
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
        $actionType = ActionType::find($taskTypeId);
        $item->actions()->create([
            'action_type_id' => $actionType->id,
        ]);
    }
}
