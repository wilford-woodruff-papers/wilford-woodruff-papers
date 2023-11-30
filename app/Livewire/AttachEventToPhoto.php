<?php

namespace App\Livewire;

use App\Models\Event;
use App\Models\Photo;
use Livewire\Component;

class AttachEventToPhoto extends Component
{
    public Photo $photo;

    public ?int $selectedEventId;

    public function render()
    {
        $events = Event::query()
            ->orderBy('start_at')
            ->get();

        return view('livewire.attach-event-to-photo', [
            'events' => $events,
        ]);
    }

    public function updatingSelectedEventId($value)
    {
        $this->attachEventToPhoto($value);
    }

    public function attachEventToPhoto($value)
    {
        if (! empty($value)) {
            $this->photo->events()->attach($value);
            $this->dispatch('eventAttachedToPhoto');
        } else {
            $this->photo->events()->detach();
            $this->dispatch('eventRemovedFromPhoto');
        }
        $this->selectedEventId = null;
        $this->photo->refresh();
    }

    public function dettachEvent($value)
    {
        $this->photo->events()->detach($value);
        $this->dispatch('eventRemovedFromPhoto');
        $this->selectedEventId = null;
        $this->photo->refresh();
    }
}
