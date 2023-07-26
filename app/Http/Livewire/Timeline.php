<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\DB;
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
        $this->groups = DB::table('events')->select('group')->distinct('group')->pluck('group')->toArray();
        //dd($this->groups);
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

        return view('livewire.timeline', [
            'hits' => collect($result->getRaw()['hits'])->groupBy('date'),
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
