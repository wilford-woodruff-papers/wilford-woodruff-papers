<?php

namespace App\Livewire\Documents;

use App\Models\Item;
use App\Models\Type;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Browse extends Component
{
    use WithPagination;

    public $decades = null;

    public $subtypes = [];

    public $direction;

    public $filters = [
        'search' => null,
        'type' => null,
        'subtype' => null,
        'decade' => null,
        'year' => null,
        'sort' => 'created:asc',
    ];

    public $types;

    public $years = null;

    protected $queryString = ['filters'];

    protected $rules = [
        'filters' => 'max:100',
    ];

    public function updatedFilters()
    {
        $this->resetPage();
    }

    public function updatingFilters($value, $key)
    {
        logger()->info(data_get($this->filters, 'search'));
        if ($key == 'decade') {
            $this->filters['year'] = null;
        }
    }

    public function mount()
    {
        /*if (empty(data_get($this->filters, 'search'))) {
            $this->types = Type::whereNull('type_id')
                ->withCount(['items' => function (Builder $query) {
                    $query->where('enabled', 1);
                }])
                ->orderBy('name', 'ASC')
                ->get();
        }*/

        $this->decades = collect([]);
        $this->years = collect([]);

        $this->subtypes = [
            'B' => 'Business/Financial',
            'C' => 'Community',
            'E' => 'Education',
            'EP' => 'Estate Papers',
            'F' => 'Family',
            'G' => 'Genealogy',
            'H' => 'Histories',
            'L' => 'Legal',
            'M' => 'Mission',
            'I' => 'Personal',
            'P' => 'Political/Government',
            'R' => 'Religious',
            'T' => 'Temple',
        ];
    }

    public function render()
    {
        if (auth()->check() && auth()->user()->hasAnyRole(['CFM Researcher'])) {
            $enabled = [0, 1];
        } else {
            $enabled = [1];
        }

        $this->types = Type::whereNull('type_id')
            ->withCount(['items' => function (Builder $query) use ($enabled) {
                $query->when(data_get($this->filters, 'search'), function ($query, $q) {
                    $query->where('name', 'LIKE', '%'.$q.'%');
                })
                    ->whereIn('enabled', $enabled);
            }])
            ->orderBy('name', 'ASC')
            ->get();

        if (data_get($this->filters, 'type') != $this->types->where('name', 'Additional')->first()->id) {
            $this->filters['subtype'] = null;
        }

        if (data_get($this->filters, 'type') == Type::firstWhere('name', 'Letters')->id) {
            $this->decades = DB::table('items')
                ->select('decade', DB::raw('count(*) as total'))
                ->when(data_get($this->filters, 'search'), function ($query, $q) {
                    $query->where('name', 'LIKE', '%'.$q.'%');
                })
                ->whereIn('enabled', $enabled)
                ->whereNotNull('decade')
                ->groupBy('decade');
            $this->decades = $this->decades->where('type_id', data_get($this->filters, 'type'))
                ->get();
        } else {
            $this->filters['decade'] = null;
            $this->filters['year'] = null;
        }

        if (data_get($this->filters, 'decade')) {
            $this->years = DB::table('items')
                ->select('year', DB::raw('count(*) as total'))
                ->when(data_get($this->filters, 'search'), function ($query, $q) {
                    $query->where('name', 'LIKE', '%'.$q.'%');
                })
                ->whereIn('enabled', $enabled)
                ->whereNotNull('year')
                ->groupBy('year');
            $this->years = $this->years->where('type_id', data_get($this->filters, 'type'))
                ->where('decade', data_get($this->filters, 'decade'))
                ->get();
        }

        $items = Item::query()
            ->with('firstPage', 'type')
            ->whereNull('item_id')
            ->whereIn('enabled', $enabled)
            ->orderBy($this->sortColumn(), $this->sortDirection())
            ->orderBy('name', 'ASC')
            ->when(data_get($this->filters, 'search'), function ($query, $q) {
                $query->where('name', 'LIKE', '%'.$q.'%');
            })
            ->when(data_get($this->filters, 'type'), function ($query, $type) {
                if (data_get($this->filters, 'type') == 'Scriptures') {
                    $query->whereIn('id', [
                        42564,
                        43689,
                        43339,
                    ]);
                } else {
                    $query->where('type_id', $type);
                }
            })
            ->when(data_get($this->filters, 'subtype'), function ($query, $subtype) {
                $query->where('pcf_unique_id_prefix', $subtype);
            })
            ->when(data_get($this->filters, 'decade'), fn ($query, $decade) => $query->where('decade', $decade))
            ->when(data_get($this->filters, 'year'), fn ($query, $year) => $query->where('year', $year));

        return view('livewire.documents.browse', [
            'items' => $items->paginate(10),
        ])
            ->layout('layouts.guest');
    }

    public function submit()
    {
    }

    private function sortColumn()
    {
        return [
            'title' => 'name',
            'created' => 'first_date',
        ][str(data_get($this->filters, 'sort', 'created:asc'))->explode(':')->first()] ?? 'first_date';
    }

    private function sortDirection()
    {
        return [
            'asc' => 'ASC',
            'desc' => 'DESC',
        ][str(data_get($this->filters, 'sort', 'added:desc'))->explode(':')->last()] ?? 'desc';
    }
}
