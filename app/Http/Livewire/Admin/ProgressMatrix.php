<?php

namespace App\Http\Livewire\Admin;

use App\Models\ActionType;
use App\Models\Page;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ProgressMatrix extends Component
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
                            ->whereIn('name', [
                                'Transcription',
                                'Verification',
                                'Stylization',                                '',
                            ])
                            ->orderBY('name', 'ASC')
                            ->get();
    }

    public function render()
    {
        if ($this->readyToLoad) {
            $pageStats = collect(DB::table('actions')
                ->select([
                    DB::raw('action_types.name AS action_name'),
                    DB::raw('actions.actionable_type AS item_type'),
                    DB::raw('types.name AS document_type'),
                    DB::raw('COUNT(*) AS total'),
                ])
                ->join('action_types', 'action_types.id', '=', 'actions.action_type_id')
                ->join('pages', 'pages.id', '=', 'actions.actionable_id')
                ->join('items', 'items.id', '=', 'pages.item_id')
                ->join('types', 'types.id', '=', 'items.type_id')
                ->where('actions.actionable_type', Page::class)
                ->whereIn('actions.action_type_id', $this->types->pluck('id')->all())
                ->groupBy([
                    'types.name',
                    'actions.actionable_type',
                    'actions.action_type_id',
                ])
                ->whereDate('completed_at', '>=', $this->dates['start'])
                ->whereDate('completed_at', '<=', $this->dates['end'])
                ->orderBy('action_types.order_column')
                ->get())
                ->groupBy('action_name');
        //dd($pageStats);
        } else {
            $pageStats = [];
        }

        return view('livewire.admin.progress-matrix', [
            'pageStats' => $pageStats,
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
