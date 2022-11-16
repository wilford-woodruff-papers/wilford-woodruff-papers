<?php

namespace App\Http\Livewire\Admin;

use App\Models\ActionType;
use App\Models\Item;
use App\Models\Page;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Reports extends Component
{
    public $dates = [
        'start' => null,
        'end' => null,
    ];

    protected $queryString = [
        'dates',
    ];

    public $readyToLoad = false;

    public $types;

    public function mount()
    {
        $this->dates = [
            'start' => now('America/Denver')->startOfMonth()->subMonthsNoOverflow()->toDateString(),
            'end' => now('America/Denver')->subMonthsNoOverflow()->endOfMonth()->toDateString(),
        ];

        $this->types = ActionType::query()
                            //->role(auth()->user()->roles)
                            ->where('type', 'Documents')
                            ->orderBY('name', 'ASC')
                            ->get();
    }

    public function render()
    {
        if ($this->readyToLoad) {
            $pageStats = DB::table('actions')
                ->select('action_types.name', 'actions.actionable_type')
                ->selectRaw('COUNT(*) AS total')
                ->join('action_types', 'action_types.id', '=', 'actions.action_type_id')
                ->where('actions.actionable_type', Page::class)
                ->whereIn('actions.action_type_id', $this->types->pluck('id')->all())
                ->groupBy(['actions.actionable_type', 'actions.action_type_id'])
                ->whereDate('completed_at', '>=', $this->dates['start'])
                ->whereDate('completed_at', '<=', $this->dates['end'])
                ->orderBy('action_types.order_column')
                ->get();

            // TODO: Need to get parents not sections
            $documentStats = DB::table('actions')
                ->selectRaw('DISTINCT `parent_item_id`')
                ->select('action_types.name', 'actions.actionable_type', 'action_types.order_column')
                ->selectRaw('COUNT(*) AS total')
                ->join('action_types', 'action_types.id', '=', 'actions.action_type_id')
                ->where('actions.actionable_type', Item::class)
                ->whereIn('actions.action_type_id', $this->types->pluck('id')->all())
                ->groupBy(['actions.actionable_type', 'actions.action_type_id'])
                ->whereDate('completed_at', '>=', $this->dates['start'])
                ->whereDate('completed_at', '<=', $this->dates['end'])
                ->orderBy('action_types.order_column')
                ->get();

            //dd($documentStats);

            $individualPageStats = DB::table('actions')
                ->select('action_types.name', 'actions.actionable_type', 'users.name AS user_name', 'users.id AS user_id')
                ->selectRaw('COUNT(*) AS total')
                ->join('action_types', 'action_types.id', '=', 'actions.action_type_id')
                ->join('users', 'users.id', '=', 'actions.completed_by')
                ->where('actions.actionable_type', Page::class)
                ->whereIn('actions.action_type_id', $this->types->pluck('id')->all())
                ->groupBy(['actions.actionable_type', 'actions.action_type_id', 'users.name', 'users.id'])
                ->whereDate('completed_at', '>=', $this->dates['start'])
                ->whereDate('completed_at', '<=', $this->dates['end'])
                ->orderBy('order_column');

            $individualStats = DB::table('actions')
                ->selectRaw('DISTINCT `parent_item_id`')
                ->select('action_types.name', 'actions.actionable_type', 'users.name AS user_name', 'users.id AS user_id')
                ->selectRaw('COUNT(*) AS total')
                ->join('action_types', 'action_types.id', '=', 'actions.action_type_id')
                ->join('users', 'users.id', '=', 'actions.completed_by')
                ->where('actions.actionable_type', Item::class)
                ->whereIn('actions.action_type_id', $this->types->pluck('id')->all())
                ->groupBy(['actions.actionable_type', 'actions.action_type_id', 'users.name', 'users.id'])
                ->whereDate('completed_at', '>=', $this->dates['start'])
                ->whereDate('completed_at', '<=', $this->dates['end'])
                ->orderBy('order_column')
                ->union($individualPageStats)
                ->get();
        } else {
            $documentStats = [];
            $pageStats = [];
            $individualStats = [];
        }

        return view('livewire.admin.reports', [
            'documentStats' => $documentStats,
            'pageStats' => $pageStats,
            'individualStats' => $individualStats,
        ])
            ->layout('layouts.admin');
    }

    public function update()
    {
    }

    public function loadStats()
    {
        $this->readyToLoad = true;
    }
}
