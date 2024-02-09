<?php

namespace App\Livewire;

use App\Models\Relationship;
use App\Models\Subject;
use Livewire\Component;

class RelativeFinderProgress extends Component
{
    public function render()
    {
        $total = Subject::query()
            ->select('id', 'name', 'pid')
            ->whereNotNull('pid')
            ->where('pid', '!=', 'n/a')
            ->whereHas('category', function ($query) {
                $query->whereIn('name', ['People'])
                    ->whereNotIn('name', ['Scriptural Figures', 'Historical Figures', 'Eminent Men and Women']);
            })
            ->where('pid', '!=', 'n/a')
            ->count();

        $checked = Relationship::query()
            ->where('user_id', auth()->id())
            ->count();

        $progress = intval(($checked / $total) * 100);

        return view('livewire.relative-finder-progress', [
            'total' => $total,
            'checked' => $checked,
            'progress' => $progress,
        ]);
    }
}
