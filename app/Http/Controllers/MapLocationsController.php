<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Meilisearch\Client;

class MapLocationsController extends Controller
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
        $client = new Client(config('scout.meilisearch.host'), config('scout.meilisearch.key'));

        $index = $client->index((app()->environment('production') ? 'resources' : 'dev-resources'));

        $result = $index->search($this->q, [
            'attributesToHighlight' => [
                'name',
                'description',
            ],
            'sort' => [(array_key_first($this->sort) ?? 'name').':'.($this->sort[array_key_first($this->sort)] ?? 'asc')],
            'hitsPerPage' => $this->hitsPerPage,
            'page' => $this->page,
            'filter' => $this->buildFilterSet(),
        ]);

        $hits = collect($result->getRaw()['hits'])
            ->map(function ($item) {
                return [
                    'id' => str(data_get($item, 'id'))->after('subject_'),
                    'name' => data_get($item, 'name'),
                    'url' => data_get($item, 'url'),
                    'description' => data_get($item, 'description'),
                    'latitude' => data_get($item, '_geo.lat'),
                    'longitude' => data_get($item, '_geo.lng'),
                    'usages' => data_get($item, 'usages'),
                ];
            });

        return $hits;

        /*return Subject::query()
            ->select(['id', 'name', 'slug', 'latitude', 'longitude', 'geolocation'])
            ->with([
                'category',
            ])
            ->whereHas('pages', function (Builder $query) {
                $query->whereHas('item', function (Builder $query) {
                    $query->where('items.enabled', true);
                });
            })
            ->whereNotNull('latitude')
            ->whereHas('category', function (Builder $query) {
                $query->where('name', 'Places');
            })
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'url' => route('subjects.show', ['subject' => $item->slug]),
                    'description' => '',
                    'latitude' => $item->latitude,
                    'longitude' => $item->longitude,
                ];
            })
            ->toArray();*/
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
