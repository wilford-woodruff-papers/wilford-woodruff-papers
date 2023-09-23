<?php

namespace App\Http\Livewire\Ai;

use Livewire\Component;

class Questions extends Component
{
    public function render()
    {
        return view('livewire.ai.questions')
            ->layout('layouts.admin');
    }
}
