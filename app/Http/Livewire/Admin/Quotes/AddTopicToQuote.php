<?php

namespace App\Http\Livewire\Admin\Quotes;

use App\Models\Quote;
use App\Models\Subject;
use LivewireUI\Modal\ModalComponent;
use Spatie\Tags\Tag;

class AddTopicToQuote extends ModalComponent
{
    public $quote;

    public $selectedTopics = [];

    public $selectedAdditionalTopics = [];

    public function mount($quote)
    {
        $this->quote = Quote::find($quote);
    }

    public function render()
    {
        return view('livewire.admin.quotes.add-topic-to-quote', [
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
        $this->quote->topics()->syncWithoutDetaching($this->selectedTopics);
        $this->quote->syncTagsWithType(array_values($this->selectedAdditionalTopics), 'quotes');
        $this->emit('refreshQuotes');
        $this->closeModal();
    }
}
