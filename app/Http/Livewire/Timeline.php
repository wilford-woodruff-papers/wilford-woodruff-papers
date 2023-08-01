<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Meilisearch\Client;

class Timeline extends Component
{
    public $page = 1;

    public $event = null;

    public $q = '';

    public $groups = [];

    public $sort = ['date' => 'asc'];

    public $hitsPerPage = 1000;

    public $filters = [
        'type' => [],
        'resource_type' => [],
        'topics' => [],
    ];

    public function mount()
    {
        $this->groups = [
            'Personal',
            'Family',
            'Religious',
            'LDS Church Context',
            'Historical Context',
        ];
    }

    public function render()
    {
        $client = new Client(config('scout.meilisearch.host'), config('scout.meilisearch.key'));

        $index = $client->index((app()->environment('production') ? 'resources' : 'dev-resources'));

        $result = $index->search($this->q, [
            'sort' => [(array_key_first($this->sort) ?? 'name').':'.($this->sort[array_key_first($this->sort)] ?? 'asc')],
            'hitsPerPage' => $this->hitsPerPage,
            'page' => $this->page,
            'filter' => $this->buildFilterSet(),
        ]);

        // TODO: This should be calculated and be the first and last years in the results.
        $yearList = range(1807, 1900);

        $monthList = collect([
            'January' => [],
            'February' => [],
            'March' => [],
            'April' => [],
            'May' => [],
            'June' => [],
            'July' => [],
            'August' => [],
            'September' => [],
            'October' => [],
            'November' => [],
            'December' => [],
        ]);

        $years = collect($result->getRaw()['hits'])
            ->groupBy('year')
            ->pipe(function ($events) use ($yearList) {
                foreach ($yearList as $year) {
                    if (! $events->get($year)) {
                        $events->put($year, []);
                    }
                }

                return $events->sortKeys();
            })
            ->map(function ($events, $year) {
                return collect($events)
                    ->groupBy('month');
            })->map(function ($events, $year) use ($monthList) {
                $events = $events->sortBy('date');

                return $monthList->merge($events);
            });

        return view('livewire.timeline', [
            'years' => $years,
        ])
            ->layout('layouts.guest');
    }

    private function buildFilterSet()
    {
        $query = [];
        $query[] = '(is_published = true OR is_published = 1)';

        $query[] = '(resource_type = "Timeline")';

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
}
