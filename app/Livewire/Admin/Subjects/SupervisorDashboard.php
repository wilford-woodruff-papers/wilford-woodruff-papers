<?php

namespace App\Livewire\Admin\Subjects;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class SupervisorDashboard extends Component
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

            $people = [];

            foreach ($months as $month) {
                $people[$month['name']]['biographies']['completed'] = DB::table('subjects')
                    ->select('users.name', DB::raw('count(*) as completed'))
                    ->join('users', 'subjects.researcher_id', '=', 'users.id')
                    ->join('category_subject', 'subjects.id', '=', 'category_subject.subject_id')
                    ->join('categories', 'categories.id', '=', 'category_subject.category_id')
                    ->whereMonth('subjects.bio_completed_at', $this->monthMap[$month['name']])
                    ->whereYear('subjects.bio_completed_at', $month['year'])
                    ->whereNotNull('researcher_id')
                    ->where('categories.name', 'People')
                    ->groupBy('researcher_id')
                    ->get();
            }

            $biographies['assigned'] = DB::table('subjects')
                ->select('users.name', DB::raw('count(*) as assigned'))
                ->join('users', 'subjects.researcher_id', '=', 'users.id')
                ->join('category_subject', 'subjects.id', '=', 'category_subject.subject_id')
                ->join('categories', 'categories.id', '=', 'category_subject.category_id')
                ->whereNull('bio_completed_at')
                ->whereNotNull('researcher_id')
                ->where('categories.name', 'People')
                ->groupBy('researcher_id')
                ->get();

        }

        return view('livewire.admin.subjects.supervisor-dashboard', [
            'months' => $months ?? [],
            'people' => $people ?? [],
            'biographies' => $biographies ?? [],
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
