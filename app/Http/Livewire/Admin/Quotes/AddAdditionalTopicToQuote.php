<?php

namespace App\Http\Livewire\Admin\Quotes;

use App\Models\Quote;
use LivewireUI\Modal\ModalComponent;
use Spatie\Tags\Tag;

class AddAdditionalTopicToQuote extends ModalComponent
{
    public $quote;

    public $selectedAdditionalTopics = [];

    public function mount($quote)
    {
        $this->quote = Quote::find($quote);
    }

    public function render()
    {
        return view('livewire.admin.quotes.add-additional-topic-to-quote', [
            'additional_topics' => Tag::query()
                ->select('name')
                ->orderBy('name->en', 'ASC')
                ->withType('quotes')
                ->get(),
        ]);
    }

    public function save()
    {
        $this->quote->syncTagsWithType(array_values($this->selectedAdditionalTopics), 'quotes');
        $this->emit('refreshQuotes');
        $this->closeModal();
    }
}
