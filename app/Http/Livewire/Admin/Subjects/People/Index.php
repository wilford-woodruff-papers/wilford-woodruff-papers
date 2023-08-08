<?php

namespace App\Http\Livewire\Admin\Subjects\People;

use App\Http\Livewire\DataTable\WithBulkActions;
use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Http\Livewire\DataTable\WithSorting;
use App\Models\Category;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Index extends Component
{
    use WithPerPagePagination, WithSorting, WithBulkActions, WithCachedRows;

    public $researchers = false;

    public $subcategories = [];

    public $categories = [];

    public $showDeleteModal = false;

    public $showEditModal = false;

    public $targetDates = [];

    public $taskTypes = [];

    public $types = [];

    public $filters = [
        'search' => '',
        'tagged' => '',
        'starts_with' => '',
        'completed' => '',
        'approved' => '',
        'researcher' => '',
        'category' => '',
        'subcategory' => '',
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
        'bio' => 'biography',
        'footnotes' => 'footnote',
        'subcategory' => 'subcategory',
        'bio_completed_at' => 'date_bio_completed',
        'bio_approved_at' => 'date_bio_approved',
    ];

    public $searchColumns = [
        'pid' => 'pid_fsid',
        'first_name' => 'given_name',
        'middle_name' => 'middle_name',
        'last_name' => 'surname',
        'alternate_names' => 'alternate_names',
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

        $this->subcategories = Subject::query()
            ->select(DB::raw('DISTINCT(subcategory)'))
            ->whereHas('category', function (Builder $query) {
                $query->whereIn('categories.name', ['People']);
            })
            ->whereNotNull('subcategory')
            ->orderBy('subcategory')
            ->pluck('subcategory')
            ->all();

        $this->categories = Category::query()
            ->where('category_id',
                Category::query()->firstWhere('name', 'People')->id
            )
            ->orderBy('name')
            ->pluck('name')
            ->all();
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
                'category',
            ])
            ->when(array_key_exists('search', $this->filters) && $this->filters['search'], function ($query, $search) {
                $query->where(function ($query) {
                    foreach (['name' => 'name', 'unique_id' => 'unique_id'] + $this->searchColumns as $key => $column) {
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
        if (array_key_exists('researcher', $this->filters) && ! empty($this->filters['researcher'])) {
            if ($this->filters['researcher'] == 'unassigned') {
                $query = $query->whereNull('researcher_id')
                    ->whereNull('researcher_text');
            } else {
                $researcher = User::find($this->filters['researcher']);
                $query = $query->where('researcher_id', $this->filters['researcher'])
                    ->orWhere('researcher_text', $researcher->name);
            }
        }
        if (array_key_exists('completed', $this->filters) && ! empty($this->filters['completed'])) {
            if ($this->filters['completed'] == 'true') {
                $query = $query->whereNotNull('bio_completed_at');
            } elseif ($this->filters['completed'] == 'false') {
                $query = $query->whereNull('bio_completed_at');
            }
        }
        if (array_key_exists('approved', $this->filters) && ! empty($this->filters['approved'])) {
            if ($this->filters['approved'] == 'true') {
                $query = $query->whereNotNull('bio_approved_at');
            } elseif ($this->filters['approved'] == 'false') {
                $query = $query->whereNull('bio_approved_at');
            }
        }

        if (array_key_exists('category', $this->filters) && ! empty($this->filters['category'])) {
            $query = $query->whereHas('category', function ($query) {
                $query->where('name', $this->filters['category']);
            });
        } else {
            $query = $query->whereHas('category', function (Builder $query) {
                $query->whereIn('categories.name', ['People']);
            });
        }

        if (array_key_exists('subcategory', $this->filters) && ! empty($this->filters['subcategory'])) {
            $query = $query->where('subcategory', $this->filters['subcategory']);
        }

        if (array_key_exists('starts_with', $this->filters) && ! empty($this->filters['starts_with'])) {
            $query = $query->where('index', $this->filters['starts_with']);
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
            'linkify' => new \Misd\Linkify\Linkify(['callback' => function ($url, $caption, $bool) {
                return '<a href="'.$url.'" class="text-secondary" target="_blank">'.str($caption)->after('//')->before('/').'</a>';
            }]),
        ])
            ->layout('layouts.admin');
    }
}
