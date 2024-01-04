<?php

namespace App\Livewire;

use App\Models\Date;
use App\src\Facets\DecadeFacet;
use App\src\Facets\ResourceTypeFacet;
use App\src\Facets\TopicFacet;
use App\src\Facets\TypeFacet;
use App\src\Facets\YearFacet;
use Asantibanez\LivewireCharts\Models\LineChartModel;
use Carbon\Carbon;
use Livewire\Component;
use Meilisearch\Client;
use Spatie\Regex\Regex;

class Search extends Component
{
    //use WithPagination;

    public $page = 1;

    public $q = '';

    public $date;

    public $decades = '';

    public $v_min = 0;

    public $v_max = 0;

    public $year_range = [];

    public $full_date_range = [];

    public $use_date_range = false;

    public $exact = false;

    public $hitsPerPage = 20;

    public $currentIndex = 'All';

    // public $indexes = [];

    public $filters = [
        'type' => [],
        'resource_type' => [],
        'topics' => [],
    ];

    public $sort = ['name' => 'asc'];

    protected $queryString = [
        'q' => ['except' => ''],
        'page' => ['except' => 1],
        'currentIndex' => ['except' => 'All'],
        'filters' => ['except' => []],
        'year_range' => ['except' => ''],
        'full_date_range' => ['except' => ''],
        'date' => ['except' => ''],
        'use_date_range' => ['except' => false],
        'sort' => ['except' => ['name' => 'asc']],
    ];

    public function mount()
    {
        if (! is_array($this->sort)) {
            $this->sort = ['name' => 'asc'];
        }
    }

    public function render()
    {
        $facets = [];
        $hits = [];

        $this->full_date_range = [
            'min' => $this->full_date_range['min'] ?? Carbon::create(Date::query()->min('date')),
            'max' => $this->full_date_range['max'] ?? Carbon::create(Date::query()->max('date')),
        ];

        $this->full_date_range['min'] = is_string($this->full_date_range['min']) ? Carbon::parse($this->full_date_range['min']) : $this->full_date_range['min'];
        $this->full_date_range['max'] = is_string($this->full_date_range['max']) ? Carbon::parse($this->full_date_range['max']) : $this->full_date_range['max'];

        $indexes = [
            'All' => [
                new ResourceTypeFacet(),
                new TopicFacet(),
            ],
            'Documents' => [
                new TypeFacet(),
                new DecadeFacet(false),
                new TopicFacet(),
                new YearFacet(false),
            ],
            'Media' => [
                new TypeFacet(),
                new TopicFacet(),
            ],
        ];

        if ($this->isDate() && ! str_contains($this->q, '"')) {
            $this->q = '"'.$this->q.'"';
        }

        $client = new Client(config('scout.meilisearch.host'), config('scout.meilisearch.key'));

        $index = $client->index((app()->environment('production') ? 'resources' : 'dev-resources'));

        $result = $index->search($this->q, [
            'showRankingScore' => true,
            'attributesToHighlight' => [
                'name',
                'description',
            ],
            'attributesToCrop' => [
                'description',
            ],
            'cropLength' => 70,
            'sort' => [(array_key_first($this->sort) ?? 'name').':'.($this->sort[array_key_first($this->sort)] ?? 'asc')],
            'hitsPerPage' => $this->hitsPerPage,
            'page' => $this->page,
            'filter' => $this->buildFilterSet(),
            'facets' => collect($indexes[$this->currentIndex])
                ->map(function ($facet) {
                    return $facet->key;
                })
                ->values()
                ->toArray(),
        ]);

        $facetDistribution = $result->getFacetDistribution();
        //dd($facetDistribution['decade']);
        $this->decades = collect([]);
        $decadeCounts = collect([]);
        $values = collect([]);

        if (! empty($stats = $result->getFacetStats())) {
            $this->decades = collect(range(max(1800, $stats['decade']['min']), $stats['decade']['max'], 10));
            foreach ($this->decades as $decade) {
                $values->push($facetDistribution['decade'][$decade] ?? 0);
            }
        }

        $this->v_min = $stats['year']['min'] ?? 1800;
        $this->v_max = $stats['year']['max'] ?? 1900;

        $documentModel = (new LineChartModel())
            ->setTitle('Documents by Decade')
            ->singleLine()
            ->setColors(['#671e0d'])
            ->setAnimated(true)
            ->withDataLabels();

        foreach ($this->decades as $decade) {
            $documentModel->addPoint($decade, $facetDistribution['decade'][$decade] ?? 0);
        }

        $this->logSearch();

        return view('livewire.search', [
            'documentModel' => $documentModel,
            'hits' => $result->getRaw()['hits'],
            'indexes' => $indexes,
            'facets' => $indexes[$this->currentIndex],
            'facetDistribution' => $facetDistribution,
            'decadeCounts' => $values,
            'first_hit' => (($this->page - 1) * $this->hitsPerPage) + ($result->getTotalHits() > 0 ? 1 : 0),
            'last_hit' => min($result->getTotalHits(), $this->page * $this->hitsPerPage),
            'first' => 1,
            'previous' => max(1, $result->getPage() - 1),
            'next' => min($result->getTotalPages(), $result->getPage() + 1),
            'last' => $result->getTotalPages(),
            'total' => $result->getTotalHits(),
            'totalPages' => $result->getTotalPages(),
        ])
            ->layout('layouts.guest', ['title' => 'Search']);
    }

    public function isDate()
    {
        return Regex::match('/^\d{4}-\d{2}-\d{2}$/', $this->q)->hasMatch()
            || Regex::match('/^\d{4}\/\d{2}\/\d{2}$/', $this->q)->hasMatch();
    }

    public function logSearch()
    {
        try {
            activity('search')
                ->event('search')
                ->withProperties(array_merge(
                    ['types' => $this->filters['resource_type'] ?? []],
                    request()->except('types'),
                    ['referrer' => request()->headers->get('referer')],
                    ['user_agent' => request()->server('HTTP_USER_AGENT')],
                ))
                ->log((! empty($this->q) ? $this->q : '*'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());
        }
    }

    public function updatedQ($value, $name)
    {
        $this->page = 1;
    }

    public function updatedFilters($value, $name)
    {
        if ($value == 0) {
            $this->filters[$name] = null;
        }
        $this->page = 1;
    }

    public function updatedPage()
    {
        $this->dispatch('scroll');
    }

    public function updatedCurrentIndex()
    {
        $this->page = 1;
        foreach ($this->filters as $key => $value) {
            $this->filters[$key] = [];
        }
        $this->v_min = null;
        $this->v_max = null;
        $this->year_range = [];
        $this->full_date_range = [];
        $this->use_date_range = false;
    }

    private function buildFilterSet()
    {
        $query = [];
        $query[] = '(is_published = true OR is_published = 1)';

        if ($this->currentIndex != 'All') {
            $query[] = '(resource_type = "'.$this->getResourceType($this->currentIndex).'")';
        }

        if (in_array($this->currentIndex, ['Articles', 'Videos'])) {
            $query[] = '(type = "'.$this->getType($this->currentIndex).'")';
        }

        if (! empty($this->year_range)) {
            [$min, $max] = $this->year_range;
            $query[] = "(year >= $min AND year <= $max)";
        }

        if (! empty($this->date)) {
            $date = Carbon::parse($this->date);
            $query[] = '(dates IS NOT NULL AND dates = "'.$date->toDateString().'")';
        }

        if ($this->use_date_range == true) {
            $query[] = '(date IS NOT NULL AND date >= '.$this->full_date_range['min']->startOfDay()->timestamp.' AND date <= '.$this->full_date_range['max']->endOfDay()->timestamp.')';
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

    private function getResourceType($key)
    {
        return match ($key) {
            'Documents' => 'Page',
            'Articles', 'Videos' => 'Media',
            'Media' => 'Media',
            'People' => 'People',
        };
    }

    private function getType($key)
    {
        return match ($key) {
            'Articles' => 'Article',
            'Videos' => 'Video',
            'People' => 'People',
        };
    }
}
