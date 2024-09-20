<?php

namespace App\Livewire\Admin\Subjects;

use App\Models\ActionType;
use App\Models\Goal;
use App\Models\Subject;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Objectives extends Component
{
    public $dates = [
        'start' => null,
        'end' => null,
    ];

    protected $queryString = [
        'stage',
    ];

    public $stage = 5;

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

    public $readyToLoad = false;

    public function mount()
    {
        $this->setDates();
    }

    public function render()
    {
        if ($this->readyToLoad) {

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

            $places = [];
            $people = [];
            $biographies = [];

            foreach ($months as $month) {
                $places[$month['name']]['added'] = Subject::query()
                    ->whereHas('category', function ($query) {
                        $query->whereIn('categories.name', ['Places']);
                    })
                    ->whereMonth('created_at', $this->monthMap[$month['name']])
                    ->whereYear('created_at', $month['year'])
                    ->count();
                $places[$month['name']]['goal'] = $goal = Goal::query()
                    ->where('type_id', 999)
                    ->where('action_type_id', ActionType::query()->where('name', 'Identify Places')->first()->id)
                    ->whereMonth('finish_at', $this->monthMap[$month['name']])
                    ->whereYear('finish_at', $month['year'])
                    ->first()->target ?? 0;

                $places[$month['name']]['actual'] = DB::table('subjects')
                    ->whereMonth('place_confirmed_at', $this->monthMap[$month['name']])
                    ->whereYear('place_confirmed_at', $month['year'])
                    ->count();
                $places[$month['name']]['percentage'] = ($places[$month['name']]['goal'] > 0) ? (intval(($places[$month['name']]['actual'] / $places[$month['name']]['goal']) * 100)) : 0;

                $people[$month['name']]['added_to_ftp'] = Subject::query()
                    ->whereHas('category', function ($query) {
                        $query->whereIn('categories.name', ['People']);
                    })
                    ->whereMonth('added_to_ftp_at', $this->monthMap[$month['name']])
                    ->whereYear('added_to_ftp_at', $month['year'])
                    ->count();
                $people[$month['name']]['goal'] = $goal = Goal::query()
                    ->where('type_id', 999)
                    ->where('action_type_id', ActionType::query()->where('name', 'Identify People')->first()->id)
                    ->whereMonth('finish_at', $this->monthMap[$month['name']])
                    ->whereYear('finish_at', $month['year'])
                    ->first()->target ?? 0;
                $people[$month['name']]['actual'] = DB::table('subjects')
                    ->whereMonth('pid_identified_at', $this->monthMap[$month['name']])
                    ->whereYear('pid_identified_at', $month['year'])
                    ->count();
                $people[$month['name']]['percentage'] = ($people[$month['name']]['goal'] > 0) ? (intval(($people[$month['name']]['actual'] / $people[$month['name']]['goal']) * 100)) : 0;

                $biographies[$month['name']]['goal'] = $goal = Goal::query()
                    ->where('type_id', 999)
                    ->where('action_type_id', ActionType::query()->where('name', 'Write Biographies')->first()->id)
                    ->whereMonth('finish_at', $this->monthMap[$month['name']])
                    ->whereYear('finish_at', $month['year'])
                    ->first()->target ?? 0;
                $biographies[$month['name']]['actual'] = DB::table('subjects')
                    ->whereMonth('bio_approved_at', $this->monthMap[$month['name']])
                    ->whereYear('bio_approved_at', $month['year'])
                    ->count();
                $biographies[$month['name']]['percentage'] = ($biographies[$month['name']]['goal'] > 0) ? (intval(($biographies[$month['name']]['actual'] / $biographies[$month['name']]['goal']) * 100)) : 0;

                $unknownPeopleIdentified[$month['name']]['goal'] = $goal = Goal::query()
                    ->where('type_id', 999)
                    ->where('action_type_id', ActionType::query()->where('name', 'Remove Unknown People')->first()->id)
                    ->whereMonth('finish_at', $this->monthMap[$month['name']])
                    ->whereYear('finish_at', $month['year'])
                    ->first()->target ?? 0;
                $unknownPeopleIdentified[$month['name']]['actual'] = DB::table('identifications')
                    ->whereMonth('completed_at', $this->monthMap[$month['name']])
                    ->whereYear('completed_at', $month['year'])
                    ->count();
                $unknownPeopleIdentified[$month['name']]['percentage'] = ($biographies[$month['name']]['goal'] > 0) ? (intval(($biographies[$month['name']]['actual'] / $biographies[$month['name']]['goal']) * 100)) : 0;
            }
        }

        return view('livewire.admin.subjects.objectives', [
            'months' => $months ?? [],
            'places' => $places ?? [],
            'people' => $people ?? [],
            'biographies' => $biographies ?? [],
            'unknownPeopleIdentified' => $unknownPeopleIdentified ?? [],
        ])
            ->layout('layouts.admin');
    }

    public function update() {}

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
            case 1:
                $this->dates = [
                    'start' => Carbon::createFromDate(2020, 3, 1, 'America/Denver')
                        ->startOfDay()
                        ->tz('UTC')
                        ->toDateTimeString(),
                    'end' => Carbon::createFromDate(2021, 2, 28, 'America/Denver')
                        ->endOfDay()
                        ->tz('UTC')
                        ->toDateTimeString(),
                ];
                break;
            case 2:
                $this->dates = [
                    'start' => Carbon::createFromDate(2021, 3, 1, 'America/Denver')
                        ->startOfDay()
                        ->tz('UTC')
                        ->toDateTimeString(),
                    'end' => Carbon::createFromDate(2022, 2, 28, 'America/Denver')
                        ->endOfDay()
                        ->tz('UTC')
                        ->toDateTimeString(),
                ];
                break;
            case 3:
                $this->dates = [
                    'start' => Carbon::createFromDate(2022, 3, 1, 'America/Denver')
                        ->startOfDay()
                        ->tz('UTC')
                        ->toDateTimeString(),
                    'end' => Carbon::createFromDate(2023, 2, 28, 'America/Denver')
                        ->endOfDay()
                        ->tz('UTC')
                        ->toDateTimeString(),
                ];
                break;
            case 4:
                $this->dates = [
                    'start' => Carbon::createFromDate(2023, 3, 1, 'America/Denver')
                        ->startOfDay()
                        ->tz('UTC')
                        ->toDateTimeString(),
                    'end' => Carbon::createFromDate(2024, 2, 29, 'America/Denver')
                        ->endOfDay()
                        ->tz('UTC')
                        ->toDateTimeString(),
                ];
                break;
            case 5:
                $this->dates = [
                    'start' => Carbon::createFromDate(2024, 3, 1, 'America/Denver')
                        ->startOfDay()
                        ->tz('UTC')
                        ->toDateTimeString(),
                    'end' => Carbon::createFromDate(2025, 2, 28, 'America/Denver')
                        ->endOfDay()
                        ->tz('UTC')
                        ->toDateTimeString(),
                ];
                break;
        }
    }
}
