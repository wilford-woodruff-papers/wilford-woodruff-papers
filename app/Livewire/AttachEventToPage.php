<?php

namespace App\Livewire;

use App\Models\Event;
use App\Models\Page;
use Livewire\Component;

class AttachEventToPage extends Component
{
    public Page $page;

    public ?int $selectedEventId;

    public function render()
    {
        $events = Event::query()
            ->orderBy('start_at')
            ->get();

        return view('livewire.attach-event-to-page', [
            'events' => $events,
        ]);
    }

    public function updatingSelectedEventId($value)
    {
        $this->attachEventToPage($value);
    }

    public function attachEventToPage($value)
    {
        if (! empty($value)) {
            $this->page->events()->attach($value);
            $this->dispatch('eventAttachedToPage');
        } else {
            $this->page->events()->detach();
            $this->dispatch('eventRemovedFromPage');
        }
        $this->selectedEventId = null;
        $this->page->refresh();
    }

    public function dettachEvent($value)
    {
        $this->page->events()->detach($value);
        $this->dispatch('eventRemovedFromPage');
        $this->selectedEventId = null;
        $this->page->refresh();
    }
}
