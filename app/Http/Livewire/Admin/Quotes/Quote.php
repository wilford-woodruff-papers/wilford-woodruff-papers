<?php

namespace App\Http\Livewire\Admin\Quotes;

use App\Models\Action;
use App\Models\ActionType;
use Livewire\Component;

class Quote extends Component
{
    public \App\Models\Quote $quote;

    protected $listeners = [

    ];

    protected $rules = [
        'quote.continued_from_previous_page' => 'boolean',
        'quote.continued_on_next_page' => 'boolean',
        'quote.author' => 'string|max:64',
    ];

    public function render()
    {
        return view('livewire.admin.quotes.quote');
    }

    public function deleteTopic($topicId)
    {
        $this->quote->topics()->detach($topicId);

        $this->quote->refresh();

        $this->render();
    }

    public function deleteQuote()
    {
        $this->quote->delete();

        $this->emitTo('admin.quotes.dashboard', 'refreshQuotes');
    }

    public function deleteAction($actionId)
    {
        Action::destroy($actionId);

        $this->quote->refresh();
    }

    public function markActionComplete()
    {
        $action = Action::create([
            'action_type_id' => ActionType::for('Quotes')->firstWhere('name', 'Approval')->id,
            'completed_at' => now(),
            'completed_by' => auth()->id(),
        ]);

        $this->quote->actions()->save($action);

        $this->quote->refresh();
    }

    public function updatedQuote($value, $key)
    {
        $this->quote->save();
    }
}
