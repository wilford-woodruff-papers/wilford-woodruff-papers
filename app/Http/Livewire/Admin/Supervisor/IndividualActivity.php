<?php

namespace App\Http\Livewire\Admin\Supervisor;

use App\Models\ActionType;
use App\Models\Page;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class IndividualActivity extends Component
{
    public $dates = [
        'start' => null,
        'end' => null,
    ];

    protected $queryString = [
        'dates',
    ];

    public $readyToLoad = false;

    public $docTypes;

    public $types;

    public $currentUserId;

    public $users;

    public $pageStats;

    public function mount()
    {
        $this->dates = [
            'start' => request('dates.start') ?? now('America/Denver')->startOfWeek()->toDateString(),
            'end' => request('dates.end') ?? now('America/Denver')->endOfWeek()->toDateString(),
        ];

        $this->currentUserId = request('dates.start') ?? auth()->id();

        $this->users = User::query()
            ->role(['Editor'])
            ->orderBy('name')
            ->get();

        $this->pageStats = [
            'completed' => [],
            'in_progress' => [],
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

        $this->docTypes = [
            'Letters',
            'Discourses',
            'Journal Sections',
            'Additional',
            'Autobiographies',
        ];
    }

    public function render()
    {
        if ($this->readyToLoad) {
            $this->pageStats['completed'] = collect(DB::table('actions')
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
                ->where('actions.completed_by', $this->currentUserId)
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

            $this->pageStats['in_progress'] = collect(DB::table('actions')
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
                ->where('actions.assigned_to', $this->currentUserId)
                ->whereNull('actions.completed_at')
                ->groupBy([
                    'types.name',
                    'actions.actionable_type',
                    'actions.action_type_id',
                ])

                ->orderBy('action_types.order_column')
                ->get())
                ->groupBy('action_name');
        }

        return view('livewire.admin.supervisor.individual-activity')
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
