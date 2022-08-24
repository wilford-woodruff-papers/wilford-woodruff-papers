<?php

namespace App\Http\Livewire;

use App\Models\Page;
use App\Models\Quote;
use App\Models\Subject;
use Illuminate\Support\Str;
use LivewireUI\Modal\ModalComponent;

class AddQuote extends ModalComponent
{
    public $page;

    public $selection;

    public $selectedTopics = [];

    public function mount($page, $selection)
    {
        $this->page = Page::find($page);

        $this->selection = $selection;
    }

    public function render()
    {
        return view('livewire.add-quote', [
            'topics' => Subject::query()
                                    ->where(function($query){
                                        $query->whereNull('subject_id')
                                            ->orWhere('subject_id', '!=',0);
                                    })
                                    ->whereRelation('category', 'name', 'Topics')
                                    ->orderBy('name')
                                    ->pluck('name', 'id')
                                    ->all()
        ]);
    }

    public function save()
    {

        $quote = Quote::create([
            'page_id' => $this->page->id,
            'text' => Str::of($this->selection)->replace('&', '&amp;'),
        ]);
        $quote->topics()->syncWithoutDetaching($this->selectedTopics);
        $this->dispatchBrowserEvent('deselect');
        $this->closeModal();
    }

}
