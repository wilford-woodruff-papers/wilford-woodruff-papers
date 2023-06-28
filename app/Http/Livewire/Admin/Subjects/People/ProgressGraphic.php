<?php

namespace App\Http\Livewire\Admin\Subjects\People;

use App\Models\Category;
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

        }

        return view('livewire.admin.people.progress-graphic', [
            'stats' => $stats ?? [],
        ])
            ->layout('layouts.admin');
    }

    public function loadStats()
    {
        $this->readyToLoad = true;
    }
}
