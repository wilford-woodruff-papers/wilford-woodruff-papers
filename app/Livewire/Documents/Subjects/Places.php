<?php

namespace App\Livewire\Documents\Subjects;

use App\Models\Page;
use App\Models\Subject;
use Livewire\Component;

class Places extends Component
{
    public $itemId;

    public function render()
    {
        $places = Subject::query()
            ->places()
            ->whereHas('pages', function ($query) {
                $query->whereIn(
                    'id',
                    Page::query()
                        ->select('id')
                        ->where('parent_item_id', $this->itemId)
                        ->pluck('id')
                        ->toArray()
                );
            })
            ->get();

        return view('livewire.documents.subjects.places', [
            'places' => $places,
        ]);
    }
}
