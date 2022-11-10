<?php

namespace App\Http\Livewire\Documents;

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

    public $direction;

    public $filters = [
        'search' => null,
        'type' => null,
        'decade' => null,
        'year' => null,
        'sort' => 'added:desc',
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
    }

    public function render()
    {
        $this->types = Type::whereNull('type_id')
                                ->withCount(['items' => function (Builder $query) {
                                    $query->when(data_get($this->filters, 'search'), function ($query, $q) {
                                        $query->where('name', 'LIKE', '%'.$q.'%');
                                    })
                                            ->where('enabled', 1);
                                }])
                                ->orderBy('name', 'ASC')
                                ->get();

        if (data_get($this->filters, 'type') == Type::firstWhere('name', 'Letters')->id) {
            $this->decades = DB::table('items')
                ->select('decade', DB::raw('count(*) as total'))
                ->when(data_get($this->filters, 'search'), function ($query, $q) {
                    $query->where('name', 'LIKE', '%'.$q.'%');
                })
                ->whereEnabled(1)
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
                ->whereEnabled(1)
                ->whereNotNull('year')
                ->groupBy('year');
            $this->years = $this->years->where('type_id', data_get($this->filters, 'type'))
                ->where('decade', data_get($this->filters, 'decade'))
                ->get();
        }

        $items = Item::query()
            ->with('firstPage', 'type')
            ->whereNull('item_id')
            ->whereEnabled(1)
            ->orderBy($this->sortColumn(), $this->sortDirection())
            ->orderBy('name', 'ASC')
            ->when(data_get($this->filters, 'search'), function ($query, $q) {
                $query->where('name', 'LIKE', '%'.$q.'%');
            })
            ->when(data_get($this->filters, 'type'), fn ($query, $type) => $query->where('type_id', $type))
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
            'created' => 'sort_date',
        ][str(data_get($this->filters, 'sort', 'added:desc'))->explode(':')->first()] ?? 'added_to_collection_at';
    }

    private function sortDirection()
    {
        return [
            'asc' => 'ASC',
            'desc' => 'DESC',
        ][str(data_get($this->filters, 'sort', 'added:desc'))->explode(':')->last()] ?? 'desc';
    }
}
