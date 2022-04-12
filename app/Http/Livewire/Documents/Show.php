<?php

namespace App\Http\Livewire\Documents;

use App\Models\Item;
use App\Models\Page;
use Livewire\Component;
use Livewire\WithPagination;

class Show extends Component
{
    use WithPagination;

    public Item $item;

    public function mount(Item $item)
    {
        $this->item = $item;
    }

    public function render()
    {
        $pages = Page::with(['dates', 'subjects', 'parent'])
            ->withCount('quotes')
            ->where('parent_item_id', $this->item->id)
            ->ordered();

        $subjects = collect([]);
        $this->item->pages->each(function($page) use (&$subjects){
            $subjects = $subjects->merge($page->subjects->all());
        });
        $subjects = $subjects->unique('id');

        $this->item->setRelation('item', $this->item);
        $this->item->setRelation('pages', $pages);

        return view('livewire.documents.show', [
            'pages' => $pages->paginate(20),
            'subjects' => $subjects,
        ])
            ->layout('layouts.guest');
    }
}
