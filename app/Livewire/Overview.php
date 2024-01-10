<?php

namespace App\Livewire;

use App\Models\Action;
use App\Models\ActionType;
use App\Models\Page;
use Livewire\Component;

class Overview extends Component
{
    public $stats;

    public $statuses;

    public $types;

    public function render()
    {
        $this->statuses = [
            'Completed',
            'In Progress',
            'Needed',
            'Overdue',
        ];
        $this->types = ActionType::query()
            ->where('type', 'Documents')
            ->get();

        $this->stats = [];

        foreach ($this->types as $type) {
            $this->stats[$type->name]['Completed'] = Action::query()
                ->where('action_type_id', $type->id)
                ->where('actionable_type', Page::class)
                ->whereNotNull('completed_at')
                ->whereNotNull('completed_by')
                ->count();
            $this->stats[$type->name]['In Progress'] = Action::query()
                ->where('action_type_id', $type->id)
                ->where('actionable_type', Page::class)
                ->whereNotNull('assigned_at')
                ->whereNotNull('assigned_to')
                ->whereNull('completed_at')
                ->whereNull('completed_by')
                ->count();
            $this->stats[$type->name]['Overdue'] = Action::query()
                ->where('action_type_id', $type->id)
                ->where('actionable_type', Page::class)
                ->whereNotNull('assigned_at')
                ->whereNotNull('assigned_to')
                ->whereNull('completed_at')
                ->whereNull('completed_by')
                ->where('assigned_at', '<', now()->subDays(14))
                ->count();
            $this->stats[$type->name]['Needed'] = Page::query()
                ->whereRelation('item', 'type_id', '!=', null)
                ->where(function ($query) use ($type) {
                    $query->whereDoesntHave('actions', function ($query) use ($type) {
                        $query->where('action_type_id', $type->id);
                    })
                        ->orWhereHas('actions', function ($query) use ($type) {
                            $query->where('action_type_id', $type->id)
                                ->whereNull('assigned_at')
                                ->whereNull('assigned_to');
                        });
                })
                ->count();

        }

        return view('livewire.overview');
    }
}
