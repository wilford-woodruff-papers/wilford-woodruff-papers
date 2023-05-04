<?php

namespace App\Http\Livewire\Admin\Places;

use App\Http\Livewire\DataTable\WithBulkActions;
use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Http\Livewire\DataTable\WithSorting;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Index extends Component
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
        'tagged' => '',
        'country' => '',
        'state' => '',
    ];

    public $columns = [
        'country' => 'country',
        'state_province' => 'state_or_province',
        'county' => 'county',
        'city' => 'city',
        'specific_place' => 'specific_place',
        'years' => 'years',
        'visited' => 'visited',
        'mentioned' => 'mentioned',
        'place_confirmed_at' => 'confirmed_at',
        'modern_location' => 'modern_location',
        'added_to_ftp_at' => 'added_to_ftp',
        'reference' => 'source',
        'notes' => 'notes',
        'researcher_text' => 'researcher',
    ];

    public $countries = [];

    public $states = [];

    protected $queryString = [
        'sorts',
        'filters' => ['except' => ''],
    ];

    protected $listeners = [
        'refreshPeople' => '$refresh',
    ];

    public function mount()
    {
        $this->countries = DB::table('subjects')
            ->select('country')
            ->distinct()
            ->whereNotNull('country')
            ->orderBy('country', 'asc')
            ->pluck('country', 'country')
            ->toArray();

        $this->states = DB::table('subjects')
            ->select('state_province')
            ->distinct()
            ->whereNotNull('state_province')
            ->orderBy('state_province', 'asc')
            ->pluck('state_province', 'state_province')
            ->toArray();

        $this->researchers = User::query()
            ->role(['Bio Editor', 'Bio Admin'])
            ->orderBy('name')
            ->get();
    }

    public function updatedFilters($value, $key)
    {
        if ($key == 'country') {
            $this->filters['state'] = null;
        }
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

        if (array_key_exists('country', $this->filters) && ! empty($this->filters['country'])) {
            $this->states = DB::table('subjects')
                ->select('state_province')
                ->distinct()
                ->where('country', $this->filters['country'])
                ->whereNotNull('state_province')
                ->orderBy('state_province', 'asc')
                ->pluck('state_province', 'state_province')
                ->toArray();
        }

        $query = Subject::query()
            ->with([
                'researcher',
            ])
            ->whereHas('category', function (Builder $query) {
                $query->whereIn('categories.name', ['Places']);
            })
            ->when(array_key_exists('search', $this->filters) && $this->filters['search'], function ($query, $search) {
                $query->where(function ($query) {
                    foreach (['name' => 'name'] + $this->columns as $key => $column) {
                        $query->orWhere($key, 'like', '%'.$this->filters['search'].'%');
                    }
                });
            })
            ->when(array_key_exists('country', $this->filters) && $this->filters['country'], function ($query, $search) {
                $query->where('country', $this->filters['country']);
            })
            ->when(array_key_exists('state', $this->filters) && $this->filters['state'], function ($query, $search) {
                $query->where('state_province', $this->filters['state']);
            });
        // TODO: Cache pages for people
        if (array_key_exists('tagged', $this->filters) && ! empty($this->filters['tagged'])) {
            if ($this->filters['tagged'] == 'true') {
                $query = $query->where('tagged_count', '>', 0);
            } elseif ($this->filters['tagged'] == 'false') {
                $query = $query->where('tagged_count', '=', 0);
            }
        }

        if (array_key_exists('researcher', $this->filters) && ! empty($this->filters['researcher'])) {
            $researcher = User::find($this->filters['researcher']);
            $query = $query->where('researcher_id', $this->filters['researcher'])
                ->orWhere('researcher_text', $researcher->name);
        }
        if (array_key_exists('completed', $this->filters) && ! empty($this->filters['completed'])) {
            if ($this->filters['completed'] == 'true') {
                $query = $query->whereNotNull('place_confirmed_at');
            } elseif ($this->filters['completed'] == 'false') {
                $query = $query->whereNull('place_confirmed_at');
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
        return view('livewire.admin.places.index', [
            'places' => $this->rows,
        ])
            ->layout('layouts.admin');
    }
}
