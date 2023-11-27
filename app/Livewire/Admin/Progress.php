<?php

namespace App\Livewire\Admin;

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
            new Period(now('America/Denver')->startOfMonth(), now('America/Denver')->endOfMonth()),
            new Period(now('America/Denver')->startOfMonth()->subMonthsNoOverflow(), now('America/Denver')->subMonthsNoOverflow()->endOfMonth()),
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
