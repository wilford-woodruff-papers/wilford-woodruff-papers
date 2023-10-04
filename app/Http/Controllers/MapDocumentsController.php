<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MapDocumentsController extends Controller
{
    public $page = 1;

    public $q = '';

    public $hitsPerPage = 5000;

    protected $queryString = [
        'geo' => ['except' => []],
        'filters' => ['except' => []],
        'q' => ['except' => ''],
        'page' => ['except' => 1],
        'sort' => ['except' => ['name' => 'asc']],
    ];

    public $filters = [

    ];

    public $sort = ['name' => 'asc'];

    public function __invoke(Request $request)
    {
        $items = Item::query()
            ->select('items.id', 'items.name', DB::raw('COUNT(page_subject.page_id) as total_usage_count'))
            ->join('pages', 'pages.parent_item_id', '=', 'items.id')
            ->join('page_subject', 'page_subject.page_id', '=', 'pages.id')
            ->where('items.enabled', true);

        if ($request->has('types')
             && ! empty($request->get('types'))
        ) {
            $items = $items->whereIn('items.type_id',
                Type::query()
                    ->whereIn('name', explode(',', $request->get('types')))
                    ->pluck('id')
                    ->all()
            );
        }

        if ($request->has('min_year')
             && ! empty($request->get('min_year'))
             && $request->has('max_year')
             && ! empty($request->get('max_year'))
        ) {
            $items = $items
                ->distinct('items.id')
                ->join('dates', 'dates.dateable_id', '=', 'pages.id')
                ->where('dates.dateable_type', 'App\Models\Page')
                ->whereYear('dates.date', '>=', $request->get('min_year'))
                ->whereYear('dates.date', '<=', $request->get('max_year'));
        }

        $items = $items
            ->where('page_subject.subject_id', $request->get('location'))
            ->groupBy('items.id', 'items.name')
            ->orderBy('items.name');

        logger()->info($items->toSql());

        $items = $items
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => str($item->name)->stripBracketedID(),
                    'count' => $item->total_usage_count,
                ];
            });

        return $items;
    }

    private function preventOutOfBounds($number)
    {
        if ($number <= -180) {
            return -180;
        }
        if ($number >= 180) {
            return 180;
        }

        return $number;
    }

    private function buildFilterSet()
    {
        $query = [];

        $query[] = '(resource_type = "Places")';
        $query[] = '_geoBoundingBox(['.request()->input('geo.northEast.lat', '69.25871535543818').', '.$this->preventOutOfBounds(request()->input('geo.northEast.lng', '15.996093750000002')).'], ['.request()->input('geo.southWest.lat', '14.356567145246045').', '.$this->preventOutOfBounds(request()->input('geo.southWest.lng', '-131.13281250000003')).'])';

        foreach ($this->filters as $filter => $values) {
            if (! empty($values)) {
                $facetValues = [];
                if (! is_array($values)) {
                    $values = [$values];
                }
                foreach ($values as $value) {
                    $facetValues[] = $filter.' = "'.$value.'"';
                }
                $query[] = '('.implode(' OR ', $facetValues).')';
            }
        }

        return empty($query) ? null : implode(' AND ', $query);
    }

    public function sortBy($field)
    {
        if (! isset($this->sort[$field])) {
            $this->sort = [];

            return $this->sort[$field] = 'asc';
        }

        if ($this->sort[$field] === 'asc') {
            return $this->sort[$field] = 'desc';
        } elseif ($this->sort[$field] === 'desc') {
            return $this->sort[$field] = 'asc';
        }

        unset($this->sort[$field]);

        $this->page = 1;
    }
}
