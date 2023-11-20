<?php

namespace App\Http\Livewire;

use App\src\Facets\TimelineCategoryFacet;
use App\src\Facets\YearFacet;
use Livewire\Component;
use Meilisearch\Client;

class Timeline extends Component
{
    public $page = 1;

    public $event = null;

    public $mapEvents = [];

    public $q = '';

    public $view = 'timeline';

    public $groups = [];

    public $sort = ['date' => 'asc'];

    public $hitsPerPage = 1000;

    public $v_min = 0;

    public $v_max = 0;

    public $year_range = [];

    public $currentIndex = 'Documents';

    public $filters = [
        'type' => [],
        'resource_type' => [],
        'topics' => [],
        'year' => [],
    ];

    protected $queryString = [
        'q' => ['except' => ''],
        'view' => ['except' => ''],
        'page' => ['except' => 1],
        'filters' => ['except' => []],
        'year_range' => ['except' => ''],
    ];

    public function mount()
    {
        $this->groups = [
            'Individual',
            'Family',
            'Personal Religious',
            'LDS Church Context',
            'Historical Context',
        ];
    }

    public function render()
    {
        $indexes = [
            new TimelineCategoryFacet(sortUsing: $this->groups),
            new YearFacet(),
            new YearFacet(false),
        ];

        $client = new Client(config('scout.meilisearch.host'), config('scout.meilisearch.key'));

        $index = $client->index((app()->environment('production') ? 'resources' : 'dev-resources'));

        $result = $index->search($this->q, [
            'sort' => [(array_key_first($this->sort) ?? 'name').':'.($this->sort[array_key_first($this->sort)] ?? 'asc')],
            'hitsPerPage' => $this->hitsPerPage,
            'page' => $this->page,
            'filter' => $this->buildFilterSet(),
            'facets' => collect($indexes)
                ->map(function ($facet) {
                    return $facet->key;
                })
                ->values()
                ->toArray(),
        ]);

        $facetDistribution = $result->getFacetDistribution();
        $facetStats = $result->getFacetStats();

        $this->v_min = intval(data_get($facetStats, 'year.min'));
        $this->v_max = intval(data_get($facetStats, 'year.max'));

        // TODO: This should be calculated and be the first and last years in the results.
        $yearList = range($this->v_min, $this->v_max);

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
        // dd($result->getRaw()['hits']);
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

        $this->dispatchBrowserEvent('update-map', ['events' => $this->reformatEventsForTimelineMap($years)]);

        return view('livewire.timeline.index', [
            'years' => $years,
            'facets' => $indexes,
            'facetDistribution' => $facetDistribution,
        ])
            ->layout('layouts.guest');
    }

    public function initializeMap()
    {
        $this->dispatchBrowserEvent('update-map', ['events' => $this->mapEvents]);
    }

    private function reformatEventsForTimelineMap($years)
    {
        $events = [];
        foreach ($years as $year => $months) {
            if ($months->filter(function ($month) {
                return count($month) > 0;
            })->count() > 0) {
                foreach ($months as $month => $monthEvents) {
                    if (count($monthEvents) > 0) {
                        foreach ($monthEvents as $event) {
                            if (! empty(data_get($event, '_geo'))) {
                                $event['name'] = str(data_get($event, 'name'))->removeSubjectTags();
                                $events[] = $event;
                            }
                        }
                    }
                }
            }
        }
        $this->mapEvents = $events;

        return $events;
    }

    private function buildFilterSet()
    {
        $query = [];
        $query[] = '(is_published = true OR is_published = 1)';

        $query[] = '(resource_type = "Timeline")';

        if (! empty($this->year_range)) {
            [$min, $max] = $this->year_range;
            $query[] = "(year >= $min AND year <= $max)";
        }

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

    public function updatingQ()
    {
        $this->emit('scroll-to-top');
    }

    public function updatingView()
    {
        $this->emit('scroll-to-timeline');
    }
}
