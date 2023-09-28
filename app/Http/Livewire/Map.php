<?php

namespace App\Http\Livewire;

use App\Models\Type;
use Livewire\Component;

class Map extends Component
{
    public $types = [];

    public function mount()
    {
        $this->types = Type::query()
            ->select([
                'id',
                'name',
            ])
            ->whereNull('type_id')
            ->orderBy('name')
            ->get();
    }

    public function render()
    {
        return view('livewire.map')
            ->layout('layouts.guest');
    }
}
