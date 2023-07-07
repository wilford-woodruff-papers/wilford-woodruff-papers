<?php

namespace App\Http\Livewire;

use Livewire\Component;

class SidePanel extends Component
{
    public bool $open = false;

    public string $name = '';

    public null|int|string $model = null;

    public string $component = '';

    protected $listeners = [
        'openPanel',
    ];

    public function openPanel(string $name, $model, string $component): void
    {
        $this->open = true;
        $this->name = $name;
        $this->modelId = $model;
        $this->component = $component;
    }

    public function render()
    {
        return view('livewire.side-panel');
    }
}
