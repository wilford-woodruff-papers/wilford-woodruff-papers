<?php

namespace App\Http\Livewire\Admin;

use App\Models\ActionType;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Reports extends Component
{
    public $types;

    public $dates = [
        'start' => null,
        'end' => null,
    ];

    public function mount()
    {
        $this->dates = [
            'start' => now('America/Denver')->startOfMonth()->subMonthsNoOverflow()->toDateString(),
            'end' => now('America/Denver')->subMonthsNoOverflow()->endOfMonth()->toDateString(),
        ];

        $this->types = ActionType::query()
                            ->role(auth()->user()->roles)
                            ->where('type', 'Documents')
                            ->orderBY('name', 'ASC')
                            ->get();
    }

    public function render()
    {
        $stats = DB::table('actions')
                    ->select('action_types.name', 'actions.actionable_type')
                    ->selectRaw('COUNT(*) AS total')
                    ->join('action_types', 'action_types.id', '=', 'actions.action_type_id')
                    ->whereIn('actions.action_type_id', $this->types->pluck('id')->all())
                    ->groupBy(['actions.actionable_type', 'actions.action_type_id'])
                    ->where('completed_at', '>=', $this->dates['start'])
                    ->where('completed_at', '<=', $this->dates['end'])
                    ->orderBy('action_types.order_column')
                    ->get();

        $individualStats = DB::table('actions')
                                ->select('action_types.name', 'actions.actionable_type', 'users.name AS user_name', 'users.id AS user_id')
                                ->selectRaw('COUNT(*) AS total')
                                ->join('action_types', 'action_types.id', '=', 'actions.action_type_id')
                                ->join('users', 'users.id', '=', 'actions.completed_by')
                                ->whereIn('actions.action_type_id', $this->types->pluck('id')->all())
                                ->groupBy(['actions.actionable_type', 'actions.action_type_id', 'users.name', 'users.id'])
                                ->where('completed_at', '>=', $this->dates['start'])
                                ->where('completed_at', '<=', $this->dates['end'])
                                ->orderBy('action_types.order_column')
                                ->get();

        return view('livewire.admin.reports', [
            'stats' => $stats,
            'individualStats' => $individualStats,
        ])
            ->layout('layouts.admin');
    }

    public function update()
    {
    }
}
