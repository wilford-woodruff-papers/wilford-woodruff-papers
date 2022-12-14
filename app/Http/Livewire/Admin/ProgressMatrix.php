<?php

namespace App\Http\Livewire\Admin;

use App\Models\ActionType;
use App\Models\Goal;
use App\Models\Page;
use App\Models\Type;
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
            'start' => request('dates.start') ?? now('America/Denver')->startOfMonth()->subMonthsNoOverflow()->toDateString(),
            'end' => request('dates.end') ?? now('America/Denver')->subMonthsNoOverflow()->endOfMonth()->toDateString(),
        ];

        $this->types = ActionType::query()
                            //->role(auth()->user()->roles)
                            ->whereIn('name', [
                                'Transcription',
                                'Verification',
                                'Stylization',
                            ])
                            ->orderBY('name', 'ASC')
                            ->get();
    }

    public function render()
    {
        $docTypes = [
            'Letters',
            'Discourses',
            'Journal Sections',
            'Additional',
            'Autobiographies',
        ];

        if ($this->readyToLoad) {
            $pageStats = collect(DB::table('actions')
                ->select([
                    DB::raw('action_types.name AS action_name'),
                    DB::raw('actions.action_type_id'),
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
            // TODO: Let's not worry about # of queries here.
            // 1. Get the sum of all goals in a given time period for document type and step
            // 2. If don't get any goals then possibly get a previous goal, but this gets tricky
            // 3. Store goals in a keyed multi dimentional array so I can retrieve them in the view
            $goals = [];
            $goalPercentages = [];

            foreach ($pageStats as $key => $stat) {
                foreach ($docTypes as $doctype) {
                    $goals[$key][$doctype] = Goal::query()
                        ->where('type_id', Type::firstWhere('name', $doctype)->id)
                        ->where('action_type_id', ActionType::firstWhere('name', $key)->id)
                        ->whereDate('finish_at', '>=', $this->dates['start'])
                        ->whereDate('finish_at', '<=', $this->dates['end'])
                        ->sum('target');

                    $goalPercentages[$key][$doctype] = 0;
                    if ($goals[$key][$doctype] > 0) {
                        $goalPercentages[$key][$doctype] = (intval(($stat->where('document_type', $doctype)->first()?->total / $goals[$key][$doctype]) * 100));
                    }
                }
            }
        } else {
            $pageStats = [];
            $goals = [];
            $goalPercentages = [];
        }

        return view('livewire.admin.progress-matrix', [
            'pageStats' => $pageStats,
            'goals' => $goals,
            'goalPercentages' => $goalPercentages,
            'docTypes' => $docTypes,
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
