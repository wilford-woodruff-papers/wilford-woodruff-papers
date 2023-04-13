<?php

namespace App\Http\Livewire\Admin\Places;

use App\Http\Livewire\DataTable\WithBulkActions;
use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Http\Livewire\DataTable\WithSorting;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
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
        'place_confirmed_at' => 'confirmed_at',
        'parent_location' => 'parent_location',
        'modern_location' => 'modern_location',
        'added_to_ftp_at' => 'added_to_ftp',
        'reference' => 'reference',
        'notes' => 'notes',
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

        $this->countries = DB::table('subjects')
            ->select('state_province')
            ->distinct()
            ->whereNotNull('state_province')
            ->orderBy('state_province', 'asc')
            ->pluck('state_province', 'state_province')
            ->toArray();
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

        if (array_key_exists('country', $this->filters) && ! empty($this->filters['state'])) {
            $this->states = DB::table('subjects')
                ->select('state_province')
                ->distinct()
                ->where('state_province', $this->filters['country'])
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
                    foreach ($this->columns as $key => $column) {
                        $query->orWhere($key, 'like', '%'.$this->filters['search'].'%');
                    }
                });
            });
        // TODO: Cache pages for people
        if (array_key_exists('tagged', $this->filters) && ! empty($this->filters['tagged'])) {
            if ($this->filters['tagged'] == 'true') {
                $query = $query->where('total_usage_count', '>', 0);
            } elseif ($this->filters['tagged'] == 'false') {
                $query = $query->where('total_usage_count', '=', 0);
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
