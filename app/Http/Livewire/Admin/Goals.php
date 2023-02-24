<?php

namespace App\Http\Livewire\Admin;

use App\Models\ActionType;
use App\Models\Goal;
use App\Models\Type;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Goals extends Component
{
    public Goal $goal;

    public $clear = true;

    public $types;

    public $doc_type;

    public $action_type;

    public $saved = false;

    protected $queryString = [
        'doc_type',
        'action_type',
    ];

    protected $rules = [
        'goal.type_id' => 'required|integer',
        'goal.action_type_id' => 'required|integer',
        'goal.finish_at' => 'required|date',
        'goal.target' => 'required|integer',
    ];

    protected $messages = [
        'goal.finish_at.required' => 'The Goal End Date is required.',
        'goal.type_id.required' => 'The Document Type is required.',
        'goal.action_type_id.required' => 'The Step is required.',
        'goal.target.required' => 'The Goal Target is required.',
        'goal.type_id.unique' => 'A goal already exists for this Document Type, Task Type, and Target Date.',
    ];

    public function mount()
    {
        if (! auth()->user()->hasRole(\App\Models\Type::query()->whereNull('type_id')->pluck('name')->transform(function ($type) {
            return $type.' Supervisor';
        })->all())) {
            abort(403);
        }
        $this->goal = new Goal(['finish_at' => now()->endOfMonth()]);
        $this->types = Type::query()
            ->get();
        $this->doc_type = $this->types->firstWhere('name', 'Journals')->id;
        $this->actionTypes = ActionType::query()
            ->whereIn('type', [
                'Documents',
                'Publish',
                'People',
                'Places',
            ])
            ->ordered()
            ->get();
        $this->doc_action_types = [
            'Transcription',
            'Verification',
            'Subject Tagging',
            'Stylization',
            'Publish',
            'Topic Tagging',
        ];
    }

    public function render()
    {
        $goals = Goal::query()
            ->with(['type', 'action_type'])
            ->when($this->doc_type, function ($query) {
                return $query->where('type_id', $this->doc_type);
            })
            ->when($this->action_type, function ($query) {
                return $query->where('action_type_id', $this->action_type);
            })
            ->orderBy('finish_at', 'DESC')
            ->orderBy('type_id', 'ASC')
            ->get();
        //dd($goals);

        return view('livewire.admin.goals', [
            'goals' => $goals,
        ])
            ->layout('layouts.admin');
    }

    public function editGoal($id)
    {
        $this->goal = Goal::firstOrNew(['id' => $id]);
    }

    public function saveGoal()
    {
        $this->rules['goal.type_id'] = [
            'required',
            'integer',
            Rule::unique('goals', 'type_id')->where(function ($query) {
                return $query->where('goals.action_type_id', $this->goal->action_type_id)
                        ->where('goals.finish_at', $this->goal->finish_at);
            })->ignore($this->goal->id),
        ];

        $this->validate();

        $this->goal->save();

        if ($this->clear === true) {
            $this->goal = new Goal(['finish_at' => now()->endOfMonth()]);
        } else {
            $this->goal = $this->goal->replicate();
            $this->created_at = now();
        }

        $this->saved = true;

        $this->emit('notify-saved');
    }

    public function deleteGoal($id)
    {
        Goal::destroy($id);

        $this->goal = new Goal(['finish_at' => now()->endOfMonth()]);
    }
}
