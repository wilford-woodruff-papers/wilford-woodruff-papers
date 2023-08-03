<?php

namespace App\Http\Livewire\Admin;

use App\Models\PeopleIdentification;
use App\Models\PlaceIdentification;
use Livewire\Component;

class ClaimIdentification extends Component
{
    public PeopleIdentification|PlaceIdentification $subject;

    public function render()
    {
        return view('livewire.admin.claim-identification');
    }

    public function claim()
    {
        $this->subject->researcher_id = auth()->user()->id;
        $this->subject->save();
        $this->subject->refresh();
    }
}
