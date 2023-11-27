<?php

namespace App\Livewire;

use Livewire\Component;

class PeopleDuplicateChecker extends Component
{
    public $readyToLoad = false;

    public \App\Models\Subject $person;

    public $duplicatePeople = [];

    public function load()
    {
        $this->readyToLoad = true;
    }

    public function render()
    {
        if ($this->readyToLoad && ! empty($this->person->slug)) {
            if (str($this->person->slug)->endsWith('-1')) {
                $this->duplicatePeople = \App\Models\Subject::query()
                    ->where('slug', str($this->person->slug)->replaceLast('-1', ''))
                    ->get();
            } else {
                $this->duplicatePeople = \App\Models\Subject::query()
                    ->where('slug', str($this->person->slug)->append('-1'))
                    ->get();
            }
        }

        return view('livewire.people-duplicate-checker');
    }
}
