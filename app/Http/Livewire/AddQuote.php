<?php

namespace App\Http\Livewire;

use App\Models\Page;
use App\Models\Quote;
use App\Models\Subject;
use Illuminate\Support\Str;
use LivewireUI\Modal\ModalComponent;
use Spatie\Tags\Tag;

class AddQuote extends ModalComponent
{
    public $author;

    public $continuedOnNextPage;

    public $continuedFromPreviousPage;

    public $page;

    public $selection;

    public $selectedTopics = [];

    public $selectedAdditionalTopics = [];

    public function mount($page, $selection)
    {
        $this->page = Page::find($page);

        $this->selection = $selection;
    }

    public function render()
    {
        return view('livewire.add-quote', [
            'topics' => Subject::query()
                ->where(function ($query) {
                    $query->whereNull('subject_id')
                        ->orWhere('subject_id', 0);
                })
                ->whereRelation('category', 'name', 'Topics')
                ->orderBy('name')
                ->pluck('name', 'id')
                ->all(),
            'additional_topics' => Tag::query()
                ->select('name')
                ->orderBy('name->en', 'ASC')
                ->withType('quotes')
                ->get(),
        ]);
    }

    public function save()
    {
        $quote = Quote::create([
            'page_id' => $this->page->id,
            'text' => Str::of($this->selection)->replace('&', '&amp;'),
            'continued_on_next_page' => $this->continuedOnNextPage,
            'continued_from_previous_page' => $this->continuedFromPreviousPage,
            'author' => $this->author,
        ]);
        $quote->topics()->syncWithoutDetaching($this->selectedTopics);
        $quote->syncTagsWithType(array_values($this->selectedAdditionalTopics), 'quotes');
        $this->dispatchBrowserEvent('deselect');
        $this->closeModal();
    }
}
