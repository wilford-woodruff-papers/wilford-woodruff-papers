<?php

namespace App\Http\Livewire\Admin\Quotes;

use Livewire\Component;
use Livewire\WithPagination;

class Search extends Component
{
    use WithPagination;

    public $readyToLoad = false;

    public $selectedTopic = null;

    public $search = null;

    public $topics = [];

    protected $queryString = [
        'selectedTopic',
        'search',
    ];

    public function render()
    {
        $quotes = \App\Models\Quote::query()
            ->with([
                'page',
                'continuation',
                'topics',
            ])
            ->whereHas('actions')
            ->whereNull('continued_from_previous_page')
            ->when($this->selectedTopic, function ($query) {
                $query->whereHas('topics', function ($query) {
                    $query->where('subjects.id', $this->selectedTopic);
                });
            })
            ->when($this->search, function ($query) {
                $query->where('text', 'LIKE', '%'.$this->search.'%');
            });

        if ($this->readyToLoad && empty($this->topics)) {
            $this->topics = \App\Models\Subject::query()
                ->select([
                    'subjects.id',
                    'subjects.name',
                ])
                ->withCount('pages')
                ->whereHas('category', function ($query) {
                    $query->where('name', 'Topics');
                })
                ->whereNull('subject_id')
                ->has('pages')
                ->orderBy('name')
                ->get()
                ->toArray();
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
    }
}
