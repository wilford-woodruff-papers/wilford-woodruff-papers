<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Meilisearch\Client;

class Search extends Component
{
    use WithPagination;

    public $q = '';

    public $filters = [

    ];

    public $sort = ['name' => 'asc'];

    protected $queryString = [
        'q' => ['except' => ''],
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
            'filter' => ['is_published = true'],
            'facets' => ['resource_type', 'type'],
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
            'facets' => $facets,
            'first' => $result->getOffset() + 1,
            'last' => min($result->getOffset() + $result->getLimit(), $result->getEstimatedTotalHits()),
            'total' => $result->getEstimatedTotalHits(),
        ])
            ->layout('layouts.guest', ['title' => 'Search']);
    }
}
