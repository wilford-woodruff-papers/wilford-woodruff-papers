<?php

namespace App\Http\Livewire\Admin\Quotes;

use App\Http\Livewire\DataTable\WithBulkActions;
use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Http\Livewire\DataTable\WithSorting;
use App\Models\Action;
use App\Models\ActionType;
use App\Models\Quote;
use Livewire\Component;

class Dashboard extends Component
{
    use WithPerPagePagination, WithSorting, WithBulkActions, WithCachedRows;

    public $showDeleteModal = false;
    public $showEditModal = false;
    public $showFilters = false;
    public $filters = [
        'text' => '',
        'topic' => '',
    ];

    protected $queryString = [
        'sorts' => ['except' => ''],
        'filters' => ['except' => ''],
    ];

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
        }, 'quotes.csv');
    }

    public function deleteSelected()
    {
        $deleteCount = $this->selectedRowsQuery->count();

        $this->selectedRowsQuery->delete();

        $this->showDeleteModal = false;

        $this->notify('You\'ve deleted '.$deleteCount.' quotes');
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
        $query = Quote::query()
                    ->with('page')
                    ->when($this->filters['text'], fn($query, $search) => $query->where('text', 'like', '%'.$search.'%'))
                    ->when($this->filters['topic'], fn($query, $topic) => $query->whereRelation(
                        'topics', 'name', '=', $topic
                    ));

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
        return view('livewire.admin.quotes.dashboard', [
            'quotes' => $this->rows,
        ]);
    }

    public function markActionComplete($quoteId)
    {
        $quote = Quote::find($quoteId);
        $action = Action::create([
            'action_type_id' => ActionType::for('Quotes')->firstWhere('name', 'Approval')->id,
            'completed_by' => auth()->id(),
        ]);
        $quote->actions()->save($action);
    }
}
