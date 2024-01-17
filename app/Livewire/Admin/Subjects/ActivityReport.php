<?php

namespace App\Livewire\Admin\Subjects;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ActivityReport extends Component
{
    public $dates = [
        'start' => null,
        'end' => null,
    ];

    protected $queryString = [
        'dates',
    ];

    public $readyToLoad = false;

    public function mount()
    {
        $this->dates = [
            'start' => now('America/Denver')->startOfWeek()->toDateString(),
            'end' => now('America/Denver')->endOfWeek()->toDateString(),
        ];
    }

    public function render()
    {
        if ($this->readyToLoad) {

            $overallStats['biographies']['completed'] = DB::table('subjects')
                ->join('category_subject', 'subjects.id', '=', 'category_subject.subject_id')
                ->join('categories', 'categories.id', '=', 'category_subject.category_id')
                ->whereDate('bio_completed_at', '>=', $this->dates['start'])
                ->whereDate('bio_completed_at', '<=', $this->dates['end'])
                ->whereNotNull('researcher_id')
                ->where('categories.name', 'People')
                ->count();

            $overallStats['places']['confirmed'] = DB::table('subjects')
                ->join('category_subject', 'subjects.id', '=', 'category_subject.subject_id')
                ->join('categories', 'categories.id', '=', 'category_subject.category_id')
                ->whereDate('place_confirmed_at', '>=', $this->dates['start'])
                ->whereDate('place_confirmed_at', '<=', $this->dates['end'])
                ->whereNotNull('researcher_id')
                ->where('categories.name', 'Places')
                ->count();

            $overallStats['biographies']['approved'] = DB::table('subjects')
                ->join('category_subject', 'subjects.id', '=', 'category_subject.subject_id')
                ->join('categories', 'categories.id', '=', 'category_subject.category_id')
                ->whereDate('bio_approved_at', '>=', $this->dates['start'])
                ->whereDate('bio_approved_at', '<=', $this->dates['end'])
                ->whereNotNull('researcher_id')
                ->where('categories.name', 'People')
                ->count();

            $overallStats['unknown_people']['removed'] = DB::table('identifications')
                ->whereDate('completed_at', '>=', $this->dates['start'])
                ->whereDate('completed_at', '<=', $this->dates['end'])
                ->whereNotNull('researcher_id')
                ->where('type', 'people')
                ->count();

            $overallStats['unknown_places']['removed'] = DB::table('identifications')
                ->whereDate('completed_at', '>=', $this->dates['start'])
                ->whereDate('completed_at', '<=', $this->dates['end'])
                ->where('type', 'place')
                ->count();

            $individualStats['biographies']['completed'] = DB::table('subjects')
                ->select('users.name', DB::raw('count(*) as completed'))
                ->join('users', 'subjects.researcher_id', '=', 'users.id')
                ->join('category_subject', 'subjects.id', '=', 'category_subject.subject_id')
                ->join('categories', 'categories.id', '=', 'category_subject.category_id')
                ->whereDate('bio_completed_at', '>=', $this->dates['start'])
                ->whereDate('bio_completed_at', '<=', $this->dates['end'])
                ->whereNotNull('researcher_id')
                ->where('categories.name', 'People')
                ->groupBy('researcher_id')
                ->get();

            $individualStats['unknown_people']['removed'] = DB::table('identifications')
                ->select('users.name', DB::raw('count(*) as completed'))
                ->join('users', 'identifications.researcher_id', '=', 'users.id')
                ->whereDate('completed_at', '>=', $this->dates['start'])
                ->whereDate('completed_at', '<=', $this->dates['end'])
                ->whereNotNull('researcher_id')
                ->where('type', 'people')
                ->groupBy('researcher_id')
                ->get();
            //dd($individualStats);
        }

        return view('livewire.admin.subjects.activity-report', [
            'overallStats' => $overallStats ?? [],
            'individualStats' => $individualStats ?? [],
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
