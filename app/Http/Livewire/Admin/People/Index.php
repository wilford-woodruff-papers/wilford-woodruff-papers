<?php

namespace App\Http\Livewire\Admin\People;

use App\Http\Livewire\DataTable\WithBulkActions;
use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Http\Livewire\DataTable\WithSorting;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class Index extends Component
{
    use WithPerPagePagination, WithSorting, WithBulkActions, WithCachedRows;

    public $showDeleteModal = false;

    public $showEditModal = false;

    public $targetDates = [];

    public $taskTypes = [];

    public $types = [];

    public $filters = [
        'search' => '',
        'tagged' => '',
    ];

    public $columns = [
        'birth_date' => 'birth_date',
        'death_date' => 'death_date',
        'life_years' => 'b_d_dates',
        'pid' => 'pid_fsid',
        'added_to_ftp_at' => 'added_to_ftp',
        'first_name' => 'given_name',
        'middle_name' => 'middle_name',
        'last_name' => 'surname',
        'suffix' => 'suffix',
        'alternate_names' => 'alternate_names',
        'maiden_name' => 'maiden_name',
        'baptism_date' => 'baptism_date',
        'z100' => 'special_categories', // key starts with z to prevent searching column
        'reference' => 'reference',
        'relationship' => 'relationship_to_ww',
        'notes' => 'notes',
        'researcher_text' => 'researcher',
        'bio_completed_at' => 'date_bio_completed',
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
        }, 'people.csv');
    }

    public function resetFilters()
    {
        $this->reset('filters');
        $this->resetPage();
    }

    public function getRowsQueryProperty()
    {
        $query = Subject::query()
            ->with([
                'researcher',
            ])
            ->whereHas('category', function (Builder $query) {
                $query->whereIn('categories.name', ['People']);
            })
            ->when(array_key_exists('search', $this->filters) && $this->filters['search'], function ($query, $search) {
                $query->where(function ($query) {
                    foreach (['name' => 'name'] + $this->columns as $key => $column) {
                        if (! str($key)->startsWith('z')) {
                            $query->orWhere($key, 'like', '%'.$this->filters['search'].'%');
                        }
                    }
                });
            });
        // TODO: Cache pages for people
        if (array_key_exists('tagged', $this->filters) && ! empty($this->filters['tagged'])) {
            if ($this->filters['tagged'] == 'true') {
                $query = $query->where('tagged_count', '>', 0);
            } elseif ($this->filters['tagged'] == 'false') {
                $query = $query->where('tagged_count', '=', 0);
            }
        }

        if (empty($this->sorts)) {
            $query = $query->orderBy('last_name', 'asc')
                ->orderBy('first_name', 'asc');
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
        return view('livewire.admin.people.index', [
            'people' => $this->rows,
        ])
            ->layout('layouts.admin');
    }
}
