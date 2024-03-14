<?php

namespace App\Livewire;

use App\Models\Item;
use App\Models\Page;
use App\Models\Subject;
use App\src\Facets\PeopleFacet;
use App\src\Facets\PlacesFacet;
use App\src\Facets\TopicFacet;
use Asantibanez\LivewireCharts\Models\PieChartModel;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Meilisearch\Client;

class DocumentDashboard extends Component
{
    public Item $item;

    public array $sections;

    public string $category = '';

    public array $categories = [];

    public $tab = 'overview';

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

    public function mount()
    {

    }

    #[Layout('layouts.guest')]
    public function render()
    {
        $facets = [
            new PeopleFacet(),
            new TopicFacet(),
            new PlacesFacet(),
        ];
        $result = null;
        if ($this->tab == 'search') {
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
                'filter' => $this->buildFilterSet($this->item->id),
                'facets' => collect($facets)
                    ->map(function ($facet) {
                        return $facet->key;
                    })
                    ->values()
                    ->toArray(),
            ]);
            //            $pages = Page::query()
            //                ->with([
            //                    'parent',
            //                ])
            //                ->where('parent_item_id', $this->item->id)
            //                ->where('transcript', 'like', '%'.$this->q.'%')
            //                ->orderBy('order', 'ASC')
            //                ->paginate(20);
        }

        $this->item
            ->loadMissing([
                'quotes.topics',
                'firstPage',
                'values',
                'values.property',
            ])
            ->setRelation('people', Subject::query()
                ->with([
                    'category',
                ])
                ->people()
                ->when($this->category, function ($query, $category) {
                    $query->whereHas('category', function ($query) use ($category) {
                        $query->where('name', $category);
                    });
                })
                ->whereHas('pages', function ($query) {
                    $query->whereIn(
                        'id',
                        Page::query()
                            ->select('id')
                            ->where('parent_item_id', $this->item->id)
                            ->pluck('id')
                            ->toArray()
                    );
                })
                ->orderBy('last_name', 'ASC')
                ->orderBy('name', 'ASC')
                ->get())

            ->setRelation('places', Subject::query()
                ->with([
                    'category',
                ])
                ->places()
                ->whereHas('pages', function ($query) {
                    $query->whereIn(
                        'id',
                        Page::query()
                            ->select('id')
                            ->where('parent_item_id', $this->item->id)
                            ->pluck('id')
                            ->toArray()
                    );
                })
                ->orderBy('name', 'ASC')
                ->get())

            ->setRelation('topics', Subject::query()
                ->with([
                    'category',
                ])
                ->index()
                ->whereNull('subject_id')
                ->whereHas('pages', function ($query) {
                    $query->whereIn(
                        'id',
                        Page::query()
                            ->select('id')
                            ->where('parent_item_id', $this->item->id)
                            ->pluck('id')
                            ->toArray()
                    );
                })
                ->orderBy('name', 'asc', SORT_NATURAL | SORT_FLAG_CASE)
                ->get());

        foreach ($this->item->people as $person) {
            foreach ($person->category as $category) {
                if (in_array($category->name, ['People'])) {
                    continue;
                }
                if (! array_key_exists($category->name, $this->categories)) {
                    $this->categories[$category->name] = 0;
                }
                $this->categories[$category->name]++;
            }
        }

        $peopleCategoryChart = (new PieChartModel())
            ->asPie()
            ->setTitle('People Categories')
            ->setAnimated(false)
            ->setLegendPosition('top')
            ->setDataLabelsEnabled(true)
            ->withoutLegend()
            ->setJsonConfig([
                'tooltip.y.formatter' => 'function (val) { return val + " people"; }',
            ])
            ->withOnSliceClickEvent('filterPeopleByCategory');
        $colors = ['rgba(11, 40, 54, .1)', 'rgba(11, 40, 54, .2)', 'rgba(11, 40, 54, .3)', 'rgba(11, 40, 54, .4)', 'rgba(11, 40, 54, .5)', 'rgba(11, 40, 54, .6)', 'rgba(11, 40, 54, .7)', 'rgba(11, 40, 54, .8)', '#0B2836'];

        foreach ($this->categories as $category => $count) {
            $peopleCategoryChart
                ->setOpacity(100)
                ->addSlice($category, $count, array_pop($colors));
        }

        return view('livewire.document-dashboard.overview', [
            'peopleCategoryChart' => $peopleCategoryChart,
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
        ])
            ->layout('layouts.guest');
    }

    #[On('filterPeopleByCategory')]
    public function filterPeopleByCategory($title)
    {
        if ($this->category === $title) {
            $this->category = '';
        } else {
            $this->category = $title;
        }

        $this->item
            ->loadMissing([
                'quotes.topics',
            ])
            ->setRelation('people', Subject::query()
                ->with([
                    'category',
                ])
                ->people()
                ->when($this->category, function ($query, $category) {
                    $query->whereHas('category', function ($query) use ($category) {
                        $query->where('name', $category);
                    });
                })
                ->whereHas('pages', function ($query) {
                    $query->whereIn(
                        'id',
                        Page::query()
                            ->select('id')
                            ->where('parent_item_id', $this->item->id)
                            ->pluck('id')
                            ->toArray()
                    );
                })
                ->orderBy('last_name', 'ASC')
                ->orderBy('name', 'ASC')
                ->get())

            ->setRelation('places', Subject::query()
                ->with([
                    'category',
                ])
                ->places()
                ->whereHas('pages', function ($query) {
                    $query->whereIn(
                        'id',
                        Page::query()
                            ->select('id')
                            ->where('parent_item_id', $this->item->id)
                            ->pluck('id')
                            ->toArray()
                    );
                })
                ->orderBy('name', 'ASC')
                ->get())

            ->setRelation('topics', Subject::query()
                ->with([
                    'category',
                ])
                ->index()
                ->whereNull('subject_id')
                ->whereHas('pages', function ($query) {
                    $query->whereIn(
                        'id',
                        Page::query()
                            ->select('id')
                            ->where('parent_item_id', $this->item->id)
                            ->pluck('id')
                            ->toArray()
                    );
                })
                ->orderBy('name', 'asc', SORT_NATURAL | SORT_FLAG_CASE)
                ->get());
    }

    private function buildFilterSet($itemId)
    {
        $query = [];
        $query[] = '(parent_id = '.$itemId.')';

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
