<?php

namespace App\Http\Livewire;

use Asantibanez\LivewireCharts\Models\LineChartModel;
use Livewire\Component;
use Meilisearch\Client;

class Search extends Component
{
    //use WithPagination;

    public $page = 1;

    public $q = '';

    public $decades = '';

    public $v_min = 0;

    public $v_max = 0;

    public $year_range = [];

    public $exact = false;

    public $hitsPerPage = 20;

    public $currentIndex = 'All';

    public $indexes = [
        'All' => ['resource_type'],
        'Documents' => ['type', 'decade', 'year'],
        'Articles' => [],
        'Videos' => [],
    ];

    public $filters = [
        'type' => [],
        'resource_type' => [],
    ];

    public $sort = ['name' => 'asc'];

    protected $queryString = [
        'q' => ['except' => ''],
        'page' => ['except' => 1],
        'currentIndex' => ['except' => 'All'],
        'filters' => ['except' => []],
        'year_range' => ['except' => ''],
        'sort' => ['except' => ['name' => 'asc']],
    ];

    public function render()
    {
        $facets = [];
        $hits = [];

        $client = new Client(config('scout.meilisearch.host'), config('scout.meilisearch.key'));

        $index = $client->index((app()->environment('production') ? 'resources' : 'dev-resources'));

        $result = $index->search($this->q, [
            'attributesToHighlight' => [
                'name',
                'description',
            ],
            'hitsPerPage' => $this->hitsPerPage,
            'page' => $this->page,
            'filter' => $this->buildFilterSet(),
            'facets' => $this->indexes[$this->currentIndex],
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

        return view('livewire.search', [
            'documentModel' => $documentModel,
            'hits' => $result->getRaw()['hits'],
            'facets' => $facetDistribution,
            'decadeCounts' => $values,
            'first_hit' => (($this->page - 1) * $this->hitsPerPage) + 1,
            'last_hit' => min($result->getTotalHits(), $this->page * $this->hitsPerPage),
            'first' => 1,
            'previous' => max(1, $result->getPage() - 1),
            'next' => min($result->getTotalPages(), $result->getPage() + 1),
            'last' => $result->getTotalPages(),
            'total' => $result->getTotalHits(),
        ])
            ->layout('layouts.guest', ['title' => 'Search']);
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
        $this->emit('scroll');
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

    private function getResourceType($key)
    {
        return match ($key) {
            'Documents' => 'Page',
            'Articles', 'Videos' => 'Media',
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
