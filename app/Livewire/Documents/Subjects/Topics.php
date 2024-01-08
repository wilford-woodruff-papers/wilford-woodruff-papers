<?php

namespace App\Livewire\Documents\Subjects;

use App\Models\Page;
use App\Models\Subject;
use Livewire\Component;

class Topics extends Component
{
    public $itemId;

    public function render()
    {
        $topics = Subject::query()
            ->index()
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

        return view('livewire.documents.subjects.topics', [
            'topics' => $topics,
        ]);
    }
}
