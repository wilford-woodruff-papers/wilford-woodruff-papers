<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class MapPagesController extends Controller
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
        return Page::query()
            ->select('pages.id', 'pages.full_name', 'pages.order')
            ->join('page_subject', 'page_subject.page_id', '=', 'pages.id')
            ->where('pages.parent_item_id', $request->get('item'))
            ->where('page_subject.subject_id', $request->get('location'))
            ->groupBy('pages.id', 'pages.full_name')
            ->orderBy('pages.full_name')
            ->get()
            ->map(function ($page) {
                return [
                    'id' => $page->id,
                    'name' => 'Page '.$page->order.' of '.str($page->full_name)->before(':')->stripBracketedID(),
                ];
            });
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
