<?php

namespace App\Livewire\Admin;

use App\Models\Action;
use Livewire\Component;

class SingleAction extends Component
{
    public $actionTypeName;

    public $actionTypeNamePrefix;

    public $class;

    public $modelId;

    public $type;

    public function mount($actionTypeName, $actionTypeNamePrefix, $modelId, $class = 'Item', $type = 'Documents')
    {
        $this->actionTypeName = $actionTypeName;
        $this->actionTypeNamePrefix = $actionTypeNamePrefix;
        $this->modelId = $modelId;
        $this->class = $class;
        $this->type = $type;
    }

    public function render()
    {
        return view('livewire.admin.single-action', [
            'action' => Action::query()
                ->where('action_type_id', \App\Models\ActionType::query()
                    ->firstOrCreate([
                        'name' => $this->actionTypeName,
                        'type' => $this->type,
                    ])
                    ->id)
                ->where('actionable_type', 'App\\Models\\'.$this->class)
                ->where('actionable_id', $this->modelId)
                ->latest()
                ->first(),
        ]);
    }

    public function markComplete()
    {
        $action = Action::create([
            'action_type_id' => \App\Models\ActionType::query()
                ->firstOrCreate([
                    'name' => $this->actionTypeName,
                    'type' => $this->type,
                ])
                ->id,
            'actionable_type' => 'App\\Models\\'.$this->class,
            'actionable_id' => $this->modelId,
            'assigned_at' => now(),
            'assigned_to' => auth()->id(),
            'completed_at' => now(),
            'completed_by' => auth()->id(),
        ]);
    }
}
