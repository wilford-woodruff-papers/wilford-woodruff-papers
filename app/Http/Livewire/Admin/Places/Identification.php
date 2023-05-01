<?php

namespace App\Http\Livewire\Admin\Places;

use App\Http\Livewire\DataTable\WithBulkActions;
use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Http\Livewire\DataTable\WithSorting;
use App\Models\PlaceIdentification;
use Livewire\Component;

class Identification extends Component
{
    use WithPerPagePagination, WithSorting, WithBulkActions, WithCachedRows;

    public $showDeleteModal = false;

    public $showEditModal = false;

    public $targetDates = [];

    public $taskTypes = [];

    public $types = [];

    public $filters = [
        'search' => '',
        'completed' => '',
    ];

    public $columns = [
        'correction_needed' => 'correction',
        'guesses' => 'possible_location',
        'editorial_assistant' => 'editorial_assistant',
        'link_to_ftp' => 'link_to_ftp',
        'notes' => 'additional_information',
        'other_records' => 'other',
        'completed_at' => 'date_completed',
    ];

    protected $queryString = [
        'sorts',
        'filters' => ['except' => ''],
    ];

    protected $listeners = [
        'refreshPeople' => '$refresh',
    ];

    public function mount()
    {
        //
    }

    public function updatedFilters()
    {
        $this->resetPage();
    }

    public function exportSelected()
    {
        return response()->streamDownload(function () {
            echo $this->selectedRowsQuery->toCsv();
        }, 'places.csv');
    }

    public function resetFilters()
    {
        $this->reset('filters');
        $this->resetPage();
    }

    public function getRowsQueryProperty()
    {
        $query = PlaceIdentification::query()
            ->when(array_key_exists('search', $this->filters) && $this->filters['search'], function ($query, $search) {
                $query->where(function ($query) {
                    foreach (['location' => 'location'] + $this->columns as $key => $column) {
                        $query->orWhere($key, 'like', '%'.$this->filters['search'].'%');
                    }
                });
            });

        if (array_key_exists('completed', $this->filters) && ! empty($this->filters['completed'])) {
            if ($this->filters['completed'] == 'true') {
                $query = $query->whereNotNull('completed_at');
            } elseif ($this->filters['completed'] == 'false') {
                $query = $query->whereNull('completed_at');
            }
        }
        if (array_key_exists('corrections', $this->filters) && ! empty($this->filters['corrections'])) {
            if ($this->filters['corrections'] == 'true') {
                $query = $query->where('correction_needed', 1);
            }
        }

        if (empty($this->sorts)) {
            $query = $query->orderBy('created_at', 'asc');
        }

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
        return view('livewire.admin.places.identification', [
            'places' => $this->rows,
        ])
            ->layout('layouts.admin');
    }
}
