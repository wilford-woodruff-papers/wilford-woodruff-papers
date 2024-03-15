<?php

namespace App\Livewire\DocumentDashboard;

use App\Models\Page;
use App\Models\Subject;
use Illuminate\Support\Collection;
use Livewire\Component;

class Places extends Component
{
    public int $itemId;

    public Collection $places;

    public function render()
    {
        $this->getPlaces();

        return view('livewire.document-dashboard.sections.places');
    }

    public function getPlaces()
    {
        $this->places = Subject::query()
            ->select('name', 'slug', 'tagged_count', 'latitude', 'longitude')
            ->with([
                'category',
            ])
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
            ->orderBy('name', 'ASC')
            ->get();
    }
}
