<?php

namespace App\Livewire\Admin;

use App\Models\Subject;
use Livewire\Component;

class ClaimSubject extends Component
{
    public Subject $subject;

    public function render()
    {
        return view('livewire.admin.claim-subject');
    }

    public function claim()
    {
        $this->subject->researcher_id = auth()->user()->id;
        $this->subject->save();
        $this->subject->refresh();
    }
}
