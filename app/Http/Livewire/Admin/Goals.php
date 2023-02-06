<?php

namespace App\Http\Livewire\Admin;

use App\Models\ActionType;
use App\Models\Goal;
use App\Models\Type;
use Livewire\Component;

class Goals extends Component
{
    public Goal $goal;

    public $types;

    protected $rules = [
        'goal.type_id' => 'required|integer',
        'goal.action_type_id' => 'required|integer',
        'goal.finish_at' => 'required|date',
        'goal.target' => 'required|integer',
    ];

    public function mount()
    {
        if (! auth()->user()->hasRole(\App\Models\Type::query()->whereNull('type_id')->pluck('name')->transform(function ($type) {
        return $type.' Supervisor';
        })->all())) {
            abort(403);
        }
        $this->goal = new Goal(['finish_at' => now()->endOfMonth()]);
        $this->types = Type::query()->get();
        $this->actionTypes = ActionType::query()->for('Documents')->ordered()->get();
    }

    public function render()
    {
        return view('livewire.admin.goals', [
            'goals' => Goal::query()
                            ->with(['type', 'action_type'])
                            ->orderBy('finish_at', 'DESC')
                            ->orderBy('type_id', 'ASC')
                            ->get(),
        ])
            ->layout('layouts.admin');
    }

    public function editGoal($id)
    {
        $this->goal = Goal::firstOrNew(['id' => $id]);
    }

    public function saveGoal()
    {
        $this->validate();

        $this->goal->save();

        $this->goal = new Goal(['finish_at' => now()->endOfMonth()]);
    }

    public function deleteGoal($id)
    {
        Goal::destroy($id);

        $this->goal = new Goal(['finish_at' => now()->endOfMonth()]);
    }
}
