<?php

namespace App\Http\Livewire\Admin\Subjects\People;

use App\Http\Livewire\DataTable\WithBulkActions;
use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Http\Livewire\DataTable\WithSorting;
use App\Models\PeopleIdentification;
use App\Models\User;
use Livewire\Component;

class Identification extends Component
{
    use WithPerPagePagination, WithSorting, WithBulkActions, WithCachedRows;

    public $researchers = false;

    public $showDeleteModal = false;

    public $showEditModal = false;

    public $targetDates = [];

    public $taskTypes = [];

    public $types = [];

    public $filters = [
        'search' => '',
        'completed' => false,
        'cant_be_identified' => '',
        'corrections' => '',
        'researcher' => '',
    ];

    public $columns = [
        'correction_needed' => 'correction',
        'researcher_id' => 'researcher',
        'editorial_assistant' => 'editorial_assistant',
        'title' => 'title',
        'first_middle_name' => 'first_and_middle_names_or_initials',
        'last_name' => 'surname_or_initial',
        'other' => 'other',
        'link_to_ftp' => 'link_to_ftp',
        'guesses' => 'guesses_or_notes_if_any',
        'location' => 'location',
        'completed_at' => 'date_completed',
        'notes' => 'research_notes',
        'cant_be_identified' => 'identifiable',
        /*'fs_id' => 'fs_id',
        'approximate_birth_date' => 'approx_birth',
        'approximate_death_date' => 'approx_death',
        'nauvoo_database' => 'nauvoo_database',
        'pioneer_database' => 'pioneer_database',
        'missionary_database' => 'missionary_database',
        'boston_index' => 'boston_index',
        'st_louis_index' => 'st_louis_index',
        'british_mission' => 'british_mission',
        'eighteen_forty_census' => '1840_census',
        'eighteen_fifty_census' => '1850_census',
        'eighteen_sixty_census' => '1860_census',
        'other_census' => 'other_census',
        'other_records' => 'other_records',*/
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
        $this->researchers = User::query()
            ->role(['Bio Editor', 'Bio Admin'])
            ->orderBy('name')
            ->get();
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
        $query = PeopleIdentification::query()
            ->with([
                'researcher',
            ])
            ->when(array_key_exists('search', $this->filters) && $this->filters['search'], function ($query, $search) {
                $query->where(function ($query) {
                    foreach (['id' => 'id'] + $this->columns as $key => $column) {
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

        if (array_key_exists('cant_be_identified', $this->filters) && ! empty($this->filters['cant_be_identified'])) {
            if ($this->filters['cant_be_identified'] == 'true') {
                $query = $query->where('cant_be_identified', true);
            } elseif ($this->filters['cant_be_identified'] == 'false') {
                $query = $query->where('cant_be_identified', false);
            }
        }

        if (array_key_exists('corrections', $this->filters) && ! empty($this->filters['corrections'])) {
            if ($this->filters['corrections'] == 'true') {
                $query = $query->where('correction_needed', 1);
            }
        }

        if (array_key_exists('researcher', $this->filters) && ! empty($this->filters['researcher'])) {
            $researcher = User::find($this->filters['researcher']);
            $query = $query->where('researcher_id', $this->filters['researcher']);
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
        return view('livewire.admin.people.identification', [
            'people' => $this->rows,
        ])
            ->layout('layouts.admin');
    }
}
