<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Meilisearch\Client;

class RelatedPagesByDate extends Component
{
    public $page;

    public $dates;

    public $index;

    /**
     * Create a new component instance.
     */
    public function __construct($page)
    {
        $this->page = $page;

        $this->dates = $page->dates->pluck('date')->all();

        $client = new Client(config('scout.meilisearch.host'), config('scout.meilisearch.key'));

        $this->index = $client->index((app()->environment('production') ? 'resources' : 'dev-resources'));
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        if (! empty($this->dates)) {
            $result = $this->index->search('', [
                'sort' => ['date:asc'],
                'hitsPerPage' => 10,
                'page' => 1,
                'filter' => $this->buildFilterSet(),
            ]);
        }

        return view('components.related-pages-by-date', [
            'hits' => isset($result) ? $result->getRaw()['hits'] : [],
        ]);
    }

    private function buildFilterSet(): string
    {
        $filters = [];

        foreach ($this->dates as $date) {
            $filters[] = "(dates = '".$date->toDateString()."')";
        }

        return '('.implode(' OR ', $filters).')';
    }
}
