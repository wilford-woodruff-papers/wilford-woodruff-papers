<?php

namespace App\Http\Livewire\Documents;

use App\Models\Item;
use App\Models\Page;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class Show extends Component
{
    use WithPagination;

    public array $filters = [
        'search' => '',
        'section' => null,
    ];

    public Item $item;

    protected $queryString = ['filters'];

    public function updatedFilters() { $this->resetPage(); }


    public function mount(Item $item)
    {
        $this->item = $item;
    }

    public function render()
    {
        $pages = Page::with(['dates', 'subjects' => function ($query) {
                            $query->whereHas('category', function (Builder $query) {
                                $query->whereIn('categories.name', ['People', 'Places']);
                            });
                        }, 'topics', 'parent', 'item'])
                        ->withCount('quotes')
                        ->where('parent_item_id', $this->item->id)
                        ->when(data_get($this->filters, 'search'), function($query, $q){
                            $query->where(function($query) use ($q) {
                                $query->where('name', 'LIKE', '%' . $q . '%')
                                      ->orWhere('transcript', 'LIKE', '%' . $q . '%');
                            });
                        })
                        ->when(data_get($this->filters, 'section'), function($query, $q){
                            $query->where('item_id', $this->filters['section']);
                        })
                        ->ordered();

        //$this->item->setRelation('item', $this->item);
        $this->item->setRelation('pages', $pages);

        $subjects = collect([]);
        $topics = collect([]);
        $this->item->pages->each(function($page) use (&$subjects, &$topics){
            $subjects = $subjects->merge($page->subjects->all());
            $topics = $topics->merge($page->topics->all());
        });
        $subjects = $subjects->unique('id');
        $topics = $topics->unique('id');

        return view('livewire.documents.show', [
            'pages' => $pages->paginate(20),
            'subjects' => $subjects,
            'topics' => $topics,
        ])
            ->layout('layouts.guest');
    }

    public function submit()
    {
        //$this->validate();

        $this->render();
    }
}
