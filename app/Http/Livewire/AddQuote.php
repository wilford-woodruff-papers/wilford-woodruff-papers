<?php

namespace App\Http\Livewire;

use App\Models\Page;
use App\Models\Quote;
use LivewireUI\Modal\ModalComponent;

class AddQuote extends ModalComponent
{
    public $page;

    public $selection;

    public function mount($page, $selection)
    {
        $this->page = Page::find($page);

        $this->selection = $selection;
    }

    public function render()
    {
        return view('livewire.add-quote');
    }

    public function save()
    {

        $quote = Quote::create([
            'page_id' => $this->page->id,
            'text' => $this->selection,
        ]);
        $this->dispatchBrowserEvent('deselect');
        $this->closeModal();
    }

}
