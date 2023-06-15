<?php

namespace App\Http\Livewire;

use App\Models\Event;
use App\Models\Photo;
use Livewire\Component;

class AttachEventToPhoto extends Component
{
    public Photo $photo;

    public int|null $selectedEventId;

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
            $this->emit('eventAttachedToPhoto');
        } else {
            $this->photo->events()->detach();
            $this->emit('eventRemovedFromPhoto');
        }
        $this->selectedEventId = null;
        $this->photo->refresh();
    }

    public function dettachEvent($value)
    {
        $this->photo->events()->detach($value);
        $this->emit('eventRemovedFromPhoto');
        $this->selectedEventId = null;
        $this->photo->refresh();
    }
}
