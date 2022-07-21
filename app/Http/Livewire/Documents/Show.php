<?php

namespace App\Http\Livewire\Documents;

use App\Models\Item;
use App\Models\Page;
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
        $pages = Page::with(['dates', 'subjects', 'parent', 'item'])
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
        $this->item->pages->each(function($page) use (&$subjects){
            $subjects = $subjects->merge($page->subjects->all());
        });
        $subjects = $subjects->unique('id');

        return view('livewire.documents.show', [
            'pages' => $pages->paginate(20),
            'subjects' => $subjects,
        ])
            ->layout('layouts.guest');
    }

    public function submit()
    {
        //$this->validate();

        $this->render();
    }
}
