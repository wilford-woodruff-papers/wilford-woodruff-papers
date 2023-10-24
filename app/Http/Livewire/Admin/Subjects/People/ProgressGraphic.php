<?php

namespace App\Http\Livewire\Admin\Subjects\People;

use App\Models\Category;
use App\Models\PeopleIdentification;
use App\Models\Subject;
use Livewire\Component;

class ProgressGraphic extends Component
{
    public $readyToLoad = false;

    public function render()
    {
        if ($this->readyToLoad) {
            $categories = Category::query()
                ->peopleCategories()
                ->pluck('id', 'name');

            foreach ($categories as $category => $id) {
                $stats[$category]['bio_completed'] = Subject::query()
                    ->whereHas('category', function ($query) use ($id) {
                        $query->where('id', $id);
                    })
                    ->whereNotNull('bio_completed_at')
                    ->count();
                $stats[$category]['total'] = Subject::query()
                    ->whereHas('category', function ($query) use ($id) {
                        $query->where('id', $id);
                    })

                    ->count();
            }

            $unknown_people = [];
            $unknown_people['removed'] = PeopleIdentification::query()
                ->whereNotNull('completed_at')
                ->count();
            $unknown_people['total'] = PeopleIdentification::query()
                ->count();

            $known_people = [];
            $known_people['bio_completed'] = Subject::query()
                ->people()
                ->whereNotNull('bio_completed_at')
                ->count();
            $known_people['pid'] = Subject::query()
                ->people()
                ->whereNotNull('pid')
                ->count();
            $known_people['incomplete_identification'] = Subject::query()
                ->people()
                ->where('incomplete_identification', 1)
                ->count();

            $known_people['total'] = Subject::query()
                ->people()
                ->count();

        }

        return view('livewire.admin.people.progress-graphic', [
            'stats' => $stats ?? [],
            'unknown_people' => $unknown_people ?? [],
            'known_people' => $known_people ?? [],
        ])
            ->layout('layouts.admin');
    }

    public function loadStats()
    {
        $this->readyToLoad = true;
    }
}
