<?php

namespace App\Livewire;

use App\Models\Page;
use Livewire\Component;

class Transcript extends Component
{
    public Page $page;

    public function mount($page)
    {
        $this->page = $page;
    }

    public function render()
    {
        return view('livewire.transcript');
    }
}
