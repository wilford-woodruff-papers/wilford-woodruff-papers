<?php

namespace App\Http\Livewire\Admin\Supervisor;

use App\Models\ActionType;
use App\Models\Item;
use App\Models\Page;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
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
        'currentUserId',
    ];

    public $readyToLoad = false;

    public $docTypes;

    public $types;

    public $currentUserId;

    public $users;

    public $activities;

    public function mount()
    {
        $this->dates = [
            'start' => request('dates.start') ?? now('America/Denver')->startOfWeek()->toDateString(),
            'end' => request('dates.end') ?? now('America/Denver')->endOfWeek()->toDateString(),
        ];

        $this->currentUserId = request('currentUserId') ?? auth()->id();

        $this->users = User::query()
            ->role(['Editor'])
            ->orderBy('name')
            ->get();

        $this->activities = [
            'completed' => [
                'stats' => [],
                'tasks' => [],
            ],
            'in_progress' => [
                'stats' => [],
                'tasks' => [],
            ],
        ];

        $this->types = ActionType::query()
            //->role(auth()->user()->roles)
//            ->whereIn('name', [
//                'Transcription',
//                'Verification',
//                'Stylization',
//            ])
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
            $this->activities['completed']['stats'] = collect(DB::table('actions')
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

            $this->activities['in_progress']['stats'] = collect(DB::table('actions')
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
                ->whereNotNull('items.pcf_unique_id')
                ->whereNull('actions.completed_at')
                ->groupBy([
                    'types.name',
                    'actions.actionable_type',
                    'actions.action_type_id',
                ])

                ->orderBy('action_types.order_column')
                ->get())
                ->groupBy('action_name');

            $this->activities['completed']['tasks'] = Item::query()
                ->whereNotNull('pcf_unique_id')
                ->whereHas('actions', function (Builder $query) {
                    $query->where('actions.completed_by', $this->currentUserId)
                        ->whereNotNull('actions.completed_at')
                        ->whereDate('actions.completed_at', '>=', $this->dates['start'])
                        ->whereDate('actions.completed_at', '<=', $this->dates['end']);
                })
                ->orderBy('items.name')
                ->get();

            $this->activities['in_progress']['tasks'] = Item::query()
                ->whereNotNull('pcf_unique_id')
                ->whereHas('actions', function (Builder $query) {
                    $query->where('actions.assigned_to', $this->currentUserId)
                        ->whereNull('actions.completed_at');
                })
                ->orderBy('items.name')
                ->get();
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
