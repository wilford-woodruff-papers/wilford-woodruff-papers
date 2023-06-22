<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Meilisearch\Client;

class Search extends Component
{
    use WithPagination;

    public $q = '';

    public $exact = false;

    public $currentIndex = 'All';

    public $indexes = [
        'All' => ['resource_type'],
        'Documents' => ['resource_type', 'type'],
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
        'currentIndex' => ['except' => 'All'],
        'filters' => ['except' => []],
        'sort' => ['except' => ['name' => 'asc']],
    ];

    public function render()
    {
        $facets = [];
        $hits = [];

        /*$hits = Resource::search($this->q, function (Indexes $meiliSearch, string $query, array $options) use (&$facets) {
            $options['sort'] = [(array_key_first($this->sort) ?? 'name').':'.($this->sort[array_key_first($this->sort)] ?? 'asc')];
            $options['filter'] = $this->buildFilterSet();
            $options['limit'] = 20;
            $options['facets'] = [
                'alpha_facet',
                'vendor_facet',
                'subject_facet',
                'format_facet',
            ];
            $results = $meiliSearch->search($query, $options);
            $facets = $results->getFacetDistribution();

            return $results;
        })
            ->query(function ($query) {
                $query->with([
                    'type',
                ]);
            })->paginate(50);*/

        $client = new Client(config('scout.meilisearch.host'), config('scout.meilisearch.key'));

        $index = $client->index('resources');

        $result = $index->search($this->q, [
            'attributesToHighlight' => [
                'name',
                'description',
            ],
            'filter' => $this->buildFilterSet(),
            'facets' => $this->indexes[$this->currentIndex],
        ]);

        /*$hits = $client->multiSearch([
            (new SearchQuery())
                ->setIndexUid('pages')
                ->setQuery('wilford')
                ->setLimit(5),
            (new SearchQuery())
                ->setIndexUid('media')
                ->setQuery('wilford')
                ->setLimit(5),
        ]);*/

        //dd($result->getRaw());

        return view('livewire.search', [
            'hits' => $result->getRaw()['hits'],
            'facets' => $result->getFacetDistribution(),
            'first' => $result->getEstimatedTotalHits() ? $result->getOffset() + 1 : 0,
            'last' => min($result->getOffset() + $result->getLimit(), $result->getEstimatedTotalHits()),
            'total' => $result->getEstimatedTotalHits(),
        ])
            ->layout('layouts.guest', ['title' => 'Search']);
    }

    public function updatedFilters($value, $name)
    {
        $this->resetPage();
    }

    public function updatedPage()
    {
        $this->emit('scroll');
    }

    private function buildFilterSet()
    {
        $query = [];
        $query[] = '(is_published = true)';

        if ($this->currentIndex != 'All') {
            $query[] = '(resource_type = "'.$this->getResourceType($this->currentIndex).'")';
        }
        if (in_array($this->currentIndex, ['Articles', 'Videos'])) {
            $query[] = '(type = "'.$this->getType($this->currentIndex).'")';
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
        };
    }

    private function getType($key)
    {
        return match ($key) {
            'Articles' => 'Article',
            'Videos' => 'Video',
        };
    }
}
