<?php

namespace App\Http\Livewire\Admin\Documents;

use App\Http\Livewire\DataTable\WithBulkActions;
use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Http\Livewire\DataTable\WithSorting;
use App\Models\Item;
use Livewire\Component;

class Dashboard extends Component
{
    use WithPerPagePagination, WithSorting, WithBulkActions, WithCachedRows;

    public $showDeleteModal = false;

    public $showEditModal = false;

    public $showFilters = false;

    public $filters = [
        'search' => '',
        'status' => '',
        'type' => '',
    ];

    protected $queryString = ['sorts'];

    protected $listeners = ['refreshQuotes' => '$refresh'];

    public function mount() {

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
            ->with('type')
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
}
