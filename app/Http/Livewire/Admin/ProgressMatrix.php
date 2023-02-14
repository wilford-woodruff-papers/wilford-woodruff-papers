<?php

namespace App\Http\Livewire\Admin;

use App\Models\ActionType;
use App\Models\Goal;
use App\Models\Item;
use App\Models\Page;
use App\Models\Type;
use App\Models\User;
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
        'currentUserId',
    ];

    public $readyToLoad = false;

    public $types;

    public $currentUserId;

    public $users;

    public $typesMap = [
        'Letters' => ['Letters'],
        'Discourses' => ['Discourses'],
        'Journals' => ['Journals', 'Journal Sections'],
        'Additional' => ['Additional'],
        'Autobiographies' => ['Autobiography Sections', 'Autobiographies'],
        'Daybooks' => ['Daybooks'],
    ];

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
                                'Publish',
                                'Stylization',
                            ])
                            ->orderBY('name', 'ASC')
                            ->get();

        $this->users = User::query()
            ->role(['Editor'])
            ->orderBy('name')
            ->get();
    }

    public function render()
    {
        $docTypes = [
            'Letters',
            'Discourses',
            'Journals',
            'Additional',
            'Daybooks',
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
                ->when($this->currentUserId, function ($query, $userId) {
                    $query->where('actions.completed_by', $userId);
                })
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

            $subjectStats['identify_people']['actual'] = DB::table('subjects')
                ->whereDate('pid_identified_at', '>=', $this->dates['start'])
                ->whereDate('pid_identified_at', '<=', $this->dates['end'])
                ->count();

            $subjectStats['write_biographies']['actual'] = DB::table('subjects')
                ->whereDate('bio_approved_at', '>=', $this->dates['start'])
                ->whereDate('bio_approved_at', '<=', $this->dates['end'])
                ->count();

            $subjectStats['identify_places']['actual'] = DB::table('subjects')
                ->whereDate('place_confirmed_at', '>=', $this->dates['start'])
                ->whereDate('place_confirmed_at', '<=', $this->dates['end'])
                ->count();

            // TODO: Pull goals and calulate percentages
            // TODO: Don't have these goals types set up yet
            // 1. How to set p goals for subjects
            // 2. I probably need to set up another table for subject goals and use it, which
            //      also would requre another editing form for subject goals.
            foreach ($subjectStats as $key => $subjectStat) {
                $subjectStats[$key]['goal'] = Goal::query()
                    ->where('type_id', 999)
                    ->where('action_type_id', ActionType::firstWhere('name', str($key)->replace('_', ' ')->title())->id)
                    ->whereDate('finish_at', '>=', $this->dates['start'])
                    ->whereDate('finish_at', '<=', $this->dates['end'])
                    ->sum('target');
                if ($subjectStats[$key]['goal'] > 0) {
                    $subjectStats[$key]['percentage'] = (intval(($subjectStats[$key]['actual'] / $subjectStats[$key]['goal']) * 100));
                } else {
                    $subjectStats[$key]['percentage'] = 0;
                }
            }

            // TODO: Let's not worry about # of queries here.
            // 1. Get the sum of all goals in a given time period for document type and step
            // 2. If don't get any goals then possibly get a previous goal, but this gets tricky
            // 3. Store goals in a keyed multi dimentional array so I can retrieve them in the view
            $goals = [];
            $goalPercentages = [];

            foreach ($pageStats as $key => $stat) {
                foreach ($docTypes as $doctype) {
                    $goals[$key][$doctype] = Goal::query()
                        ->where('type_id', Type::whereIn('name', $this->typesMap[$doctype])->first()->id)
                        ->where('action_type_id', ActionType::firstWhere('name', $key)->id)
                        ->whereDate('finish_at', '>=', $this->dates['start'])
                        ->whereDate('finish_at', '<=', $this->dates['end'])
                        ->sum('target');

                    $goalPercentages[$key][$doctype] = 0;
                    if ($goals[$key][$doctype] > 0) {
                        $goalPercentages[$key][$doctype] = (intval(($stat->whereIn('document_type', $this->typesMap[$doctype])->first()?->total / $goals[$key][$doctype]) * 100));
                    }
                }
            }

            foreach ($docTypes as $doctype) {
                $pageCounts[$doctype] = Item::query()
                    ->where(function ($query) {
                        $query->where('auto_page_count', '<=', 0)
                            ->orWhereNull('auto_page_count');
                    })
                    ->whereRelation('type', function ($query) use ($doctype) {
                        $query->whereIn('name', $this->typesMap[$doctype]);
                    })
                    ->sum('manual_page_count')
                    + Item::query()
                        ->where('auto_page_count', '>', 0)
                        ->whereRelation('type', function ($query) use ($doctype) {
                            $query->whereIn('name', $this->typesMap[$doctype]);
                        })
                        ->sum('auto_page_count');
            }
        } else {
            $pageStats = [];
            $goals = [];
            $goalPercentages = [];
            $pageCounts = [];
            $subjectStats = [
                'identify_people' => [
                    'actual' => 0,
                    'goal' => 0,
                    'percentage' => 0,
                ],
                'write_biographies' => [
                    'actual' => 0,
                    'goal' => 0,
                    'percentage' => 0,
                ],
                'identify_places' => [
                    'actual' => 0,
                    'goal' => 0,
                    'percentage' => 0,
                ],
            ];
        }

        return view('livewire.admin.progress-matrix', [
            'pageStats' => $pageStats,
            'goals' => $goals,
            'goalPercentages' => $goalPercentages,
            'docTypes' => $docTypes,
            'subjectStats' => $subjectStats,
            'pageCounts' => $pageCounts,

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
