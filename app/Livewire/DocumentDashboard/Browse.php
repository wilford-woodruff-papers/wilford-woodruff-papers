<?php

namespace App\Livewire\DocumentDashboard;

use App\src\Facets\PeopleFacet;
use App\src\Facets\PlacesFacet;
use App\src\Facets\TopicFacet;
use Livewire\Attributes\Lazy;
use Livewire\Component;
use Meilisearch\Client;

#[Lazy]
class Browse extends Component
{
    public int $itemId;

    public $currentIndex = 'Pages';

    public $q = null;

    public $page = 1;

    public $hitsPerPage = 20;

    public $filters = [
        'people' => [],
        'places' => [],
        'topics' => [],
    ];

    public $v_min = 0;

    public $v_max = 0;

    public $year_range = [];

    public $full_date_range = ['min' => 0, 'max' => 0];

    protected $queryString = [
        'q' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    public function render()
    {
        $facets = [
            new PeopleFacet(),
            new TopicFacet(),
            new PlacesFacet(),
        ];

        $result = null;

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
            'sort' => ['order:asc'],
            'hitsPerPage' => $this->hitsPerPage,
            'page' => $this->page,
            'filter' => $this->buildFilterSet(),
            'facets' => collect($facets)
                ->map(function ($facet) {
                    return $facet->key;
                })
                ->values()
                ->toArray(),
        ]);

        return view('livewire.document-dashboard.sections.browse', [
            'hits' => $result?->getRaw()['hits'] ?? collect(),
            'facets' => $facets,
            'facetDistribution' => $result?->getFacetDistribution() ?? [],
            'first_hit' => (($this->page - 1) * $this->hitsPerPage) + ($result?->getTotalHits() > 0 ? 1 : 0),
            'last_hit' => min($result?->getTotalHits(), $this->page * $this->hitsPerPage),
            'first' => 1,
            'previous' => max(1, $result?->getPage() - 1),
            'next' => min($result?->getTotalPages(), $result?->getPage() + 1),
            'last' => $result?->getTotalPages(),
            'total' => $result?->getTotalHits(),
            'totalPages' => $result?->getTotalPages(),
        ]);
    }

    private function buildFilterSet()
    {
        $query = [];
        $query[] = '(parent_id = '.$this->itemId.')';

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

    public function placeholder()
    {
        return <<<'HTML'
        <div class="flex w-full aspect-[16/9] items-center justify-center">
            <x-heroicon-o-arrow-path class="w-16 h-16 text-gray-400 animate-spin" />
        </div>
        HTML;
    }
}
