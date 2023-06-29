<?php

namespace App\Http\Livewire\Admin\Quotes;

use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Tags\Tag;

class Search extends Component
{
    use WithPagination;

    public $readyToLoad = false;

    public $selectedTopic = null;

    public $selectedAdditionalTopic = null;

    public $search = null;

    public $topics;

    public $additionalTopics;

    protected $queryString = [
        'selectedTopic',
        'selectedAdditionalTopic',
        'search',
    ];

    public function render()
    {
        $quotes = \App\Models\Quote::query()
            ->with([
                'page',
                'page.parent',
                'continuation',
                'topics',
                'tags',
            ])
            ->whereHas('actions')
            ->whereNull('continued_from_previous_page')
            ->when($this->selectedTopic, function ($query) {
                $query->whereHas('topics', function ($query) {
                    $query->where('subjects.id', $this->selectedTopic);
                });
            })->when($this->selectedAdditionalTopic, function ($query) {
                $query->withAnyTags([$this->selectedAdditionalTopic], 'quotes');
            })
            ->when($this->search, function ($query) {
                $query->where('text', 'LIKE', '%'.$this->search.'%');
            });

        if ($this->readyToLoad) {
            $this->topics = \App\Models\Subject::query()
                ->select([
                    'subjects.id',
                    'subjects.name',
                    'subjects.slug',
                ])
                ->with([
                    'category',
                ])
                ->withCount(['quotes' => function (Builder $query) {
                    $query->whereHas('actions');
                }])
                ->whereHas('category', function (Builder $query) {
                    $query->whereIn('categories.name', ['Topic', 'Index']);
                })
                ->whereNull('subject_id')
                ->has('pages')
                ->orderBy('name')
                ->get();

            $this->additionalTopics = Tag::query()
                ->select('id', 'name')
                ->withType('quotes')
                ->orderBy('name')
                ->get();
        }

        return view('livewire.admin.quotes.search', [
            'quotes' => $quotes->paginate(20),
        ])
            ->layout('layouts.admin');
    }

    public function clearTopic()
    {
        $this->selectedTopic = null;
    }

    public function clearAdditionalTopic()
    {
        $this->selectedAdditionalTopic = null;
    }

    public function load()
    {
        $this->readyToLoad = true;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSelectedTopic()
    {
        $this->resetPage();
        $this->emit('scroll-to-top');
    }

    public function updatingPage()
    {
        $this->emit('scroll-to-top');
    }
}
