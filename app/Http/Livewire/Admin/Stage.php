<?php

namespace App\Http\Livewire\Admin;

use App\Models\ActionType;
use App\Models\Goal;
use App\Models\Page;
use App\Models\Type;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Stage extends Component
{
    public $dates = [
        'start' => null,
        'end' => null,
    ];

    protected $queryString = [
        'stage',
    ];

    public $stage = 3;

    public $monthMap = [
        'January' => 1,
        'February' => 2,
        'March' => 3,
        'April' => 4,
        'May' => 5,
        'June' => 6,
        'July' => 7,
        'August' => 8,
        'September' => 9,
        'October' => 10,
        'November' => 11,
        'December' => 12,
    ];

    public $actionTypes;

    public $readyToLoad = false;

    public function mount()
    {
        $this->setDates();

        $this->actionTypes = ActionType::query()
            ->whereIn('name', [
                'Transcription',
                'Verification',
                'Stylization',
                'Subject Tagging',
                'Topic Tagging',
                'Publish',
            ])
            ->orderBY('name', 'ASC')
            ->get();
    }

    public function render()
    {
        if ($this->readyToLoad) {
            $typesMap = [
                'Letters' => ['Letters'],
                'Discourses' => ['Discourses'],
                'Journal Sections' => ['Journals', 'Journal Sections'],
                'Additional' => ['Additional'],
                'Autobiographies' => ['Autobiography Sections', 'Autobiographies'],
            ];

            $docTypes = [
                'Letters',
                'Discourses',
                'Journal Sections',
                'Additional',
                'Autobiographies',
            ];

            $month = [];
            $period = new \DatePeriod(
                new \DateTime($this->dates['start']),
                new \DateInterval('P1M'),
                new \DateTime($this->dates['end'])
            );
            foreach ($period as $dt) {
                $months[] = [
                    'name' => $dt->format('F'),
                    'year' => $dt->format('Y'),
                ];
            }

            $pageStats = collect(DB::table('actions')
                ->select([
                    DB::raw('action_types.name AS action_name'),
                    DB::raw('actions.action_type_id'),
                    DB::raw('actions.actionable_type AS item_type'),
                    DB::raw('types.name AS document_type'),
                    DB::raw('COUNT(*) AS total'),
                    DB::raw('MONTH(actions.completed_at) as month'),
                ])
                ->join('action_types', 'action_types.id', '=', 'actions.action_type_id')
                ->join('pages', 'pages.id', '=', 'actions.actionable_id')
                ->join('items', 'items.id', '=', 'pages.item_id')
                ->join('types', 'types.id', '=', 'items.type_id')
                ->where('actions.actionable_type', Page::class)
                ->whereIn('actions.action_type_id', $this->actionTypes->pluck('id')->all())
                ->groupBy([
                    DB::raw('MONTH(actions.completed_at)'),
                    'types.name',
                    'actions.actionable_type',
                    'actions.action_type_id',
                ])
                ->whereDate('completed_at', '>=', $this->dates['start'])
                ->whereDate('completed_at', '<=', $this->dates['end'])
                ->orderBy('action_types.order_column')
                ->get());

            $stats = [];
            foreach ($docTypes as $doctype) {
                $index = 0;
                $summary = [
                    'goal' => [
                        'Transcription' => 0,
                        'Verification' => 0,
                        'Stylization' => 0,
                        'Subject Tagging' => 0,
                        'Topic Tagging' => 0,
                        'Publish' => 0,

                    ],
                    'completed' => [
                        'Transcription' => 0,
                        'Verification' => 0,
                        'Stylization' => 0,
                        'Subject Tagging' => 0,
                        'Topic Tagging' => 0,
                        'Publish' => 0,

                    ],
                    'percentage' => [
                        'Transcription' => 0,
                        'Verification' => 0,
                        'Stylization' => 0,
                        'Subject Tagging' => 0,
                        'Topic Tagging' => 0,
                        'Publish' => 0,

                    ],
                ];
                foreach ($months as $month) {
                    foreach ([
                        'Transcription',
                        'Verification',
                        'Subject Tagging',
                        'Topic Tagging',
                        'Stylization',
                    ] as $actionType) {
                        $stats[$doctype][$month['name']][$actionType] = [
                            'goal' => $goal = Goal::query()
                                ->where('type_id', Type::firstWhere('name', $doctype)->id)
                                ->where('action_type_id', $this->actionTypes->where('name', $actionType)->first()->id)
                                ->whereMonth('finish_at', $this->monthMap[$month['name']])
                                ->whereYear('finish_at', $month['year'])
                                ->first()->target ?? 0,
                            'completed' => $completed = $pageStats->where('document_type', $doctype)
                                ->where('action_name', $actionType)
                                ->where('month', $this->monthMap[$month['name']])
                                ->first()?->total,
                            'percentage' => ($goal > 0) ? (intval(($completed / $goal) * 100)) : 0,
                        ];
                        $summary['goal'][$actionType] += $goal;
                        $summary['completed'][$actionType] += $completed;
                        //$summary['completed_crowd'] += $completed_crowd;
                        $summary['percentage'][$actionType] = ($summary['goal'][$actionType] > 0) ? (intval(($summary['completed'][$actionType] / $summary['goal'][$actionType]) * 100)) : 0;
                        // TODO: This is showng cumulative percentage, not quarterly percentage
                    }
                    if (($index + 1) % 3 == 0) {
                        foreach ([
                            'Transcription',
                            'Verification',
                            'Subject Tagging',
                            'Topic Tagging',
                            'Stylization',
                        ] as $actionType) {
                            $stats[$doctype][$month['name']][$actionType]['summary'] = [
                                'goal' => $summary['goal'][$actionType],
                                'completed' => $summary['completed'][$actionType],
                                'percentage' => $summary['percentage'][$actionType],
                            ];
                        }
                        $summary = [
                            'goal' => [
                                'Transcription' => 0,
                                'Verification' => 0,
                                'Stylization' => 0,
                                'Subject Tagging' => 0,
                                'Topic Tagging' => 0,
                                'Publish' => 0,

                            ],
                            'completed' => [
                                'Transcription' => 0,
                                'Verification' => 0,
                                'Stylization' => 0,
                                'Subject Tagging' => 0,
                                'Topic Tagging' => 0,
                                'Publish' => 0,

                            ],
                            'percentage' => [
                                'Transcription' => 0,
                                'Verification' => 0,
                                'Stylization' => 0,
                                'Subject Tagging' => 0,
                                'Topic Tagging' => 0,
                                'Publish' => 0,

                            ],
                        ];
                    }
                    $index = $index + 1;
                }
            }
        }

        return view('livewire.admin.stage', [
            'months' => $months ?? [],
            'stats' => $stats ?? [],
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

    public function updatedStage($value)
    {
        $this->setDates();
    }

    private function setDates()
    {
        switch ($this->stage) {
            case 3:
                $this->dates = [
                    'start' => '2022-03-01',
                    'end' => '2023-02-28',
                ];
                break;
        }
    }
}
