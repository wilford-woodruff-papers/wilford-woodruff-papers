<?php

namespace App\Http\Livewire\Ai;

use Livewire\Component;

class Session extends Component
{
    public function render()
    {
        return view('livewire.ai.session')
            ->layout('layouts.admin');
    }
}
