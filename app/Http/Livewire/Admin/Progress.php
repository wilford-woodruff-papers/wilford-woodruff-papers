<?php

namespace App\Http\Livewire\Admin;

use App\Models\ActionType;
use App\Models\Period;
use App\Models\Type;
use Livewire\Component;

class Progress extends Component
{
    public $actionTypes;

    public $months;

    public $types;

    public function render()
    {
        $this->periods = collect([
            new Period(now()->startOfMonth(), now()->endOfMonth()),
            new Period(now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()),
        ]);

        $this->types = Type::query()
                                ->role(auth()->user()->roles)
                                ->orderBY('name', 'ASC')
                                ->get();

        $this->actionTypes = ActionType::query()
                                            ->for('Documents')
                                            ->role(auth()->user()->roles)
                                            ->ordered()
                                            ->get();

        return view('livewire.admin.progress');
    }
}
