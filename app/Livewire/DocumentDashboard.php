<?php

namespace App\Livewire;

use App\Models\Item;
use App\Models\Page;
use App\Models\Subject;
use Livewire\Component;

class DocumentDashboard extends Component
{
    public Item $item;

    public array $sections;

    public function mount()
    {
        $this->item
            ->loadMissing([
            ])
            ->setRelation('people', Subject::query()
                ->with([
                    'category',
                ])
                ->people()
                ->whereHas('pages', function ($query) {
                    $query->whereIn(
                        'id',
                        Page::query()
                            ->select('id')
                            ->where('parent_item_id', $this->item->id)
                            ->pluck('id')
                            ->toArray()
                    );
                })
                ->get())

            ->setRelation('places', Subject::query()
                ->places()
                ->whereHas('pages', function ($query) {
                    $query->whereIn(
                        'id',
                        Page::query()
                            ->select('id')
                            ->where('parent_item_id', $this->item->id)
                            ->pluck('id')
                            ->toArray()
                    );
                })
                ->get())

            ->setRelation('topics', Subject::query()
                ->index()
                ->whereNull('subject_id')
                ->whereHas('pages', function ($query) {
                    $query->whereIn(
                        'id',
                        Page::query()
                            ->select('id')
                            ->where('parent_item_id', $this->item->id)
                            ->pluck('id')
                            ->toArray()
                    );
                })
                ->orderBy('name', 'asc', SORT_NATURAL | SORT_FLAG_CASE)
                ->get());
        $this->sections = [
            'Person' => [
                'name' => 'People',
                'items' => $people ?? collect(),
                'icon' => 'heroicon-o-user-group',
                'view' => 'public.day-in-the-life.sections.people',
            ],
            'Place' => [
                'name' => 'Places',
                'items' => $places ?? collect(),
                'icon' => 'heroicon-o-map',
                'view' => 'public.day-in-the-life.sections.places',
            ],
            'Event' => [
                'name' => 'Events',
                'items' => $events ?? collect(),
                'icon' => 'heroicon-o-calendar-days',
                'view' => 'public.day-in-the-life.sections.events',
            ],
            'Quote' => [
                'name' => 'Quotes',
                'items' => $quotes ?? collect(),
                'icon' => 'ri-double-quotes-l',
                'view' => 'public.day-in-the-life.sections.quotes',
            ],
            'Document' => [
                'name' => 'Related Documents',
                'items' => $pages ?? collect(),
                'icon' => 'heroicon-o-document-text',
                'view' => 'public.day-in-the-life.sections.documents',
            ],
        ];
    }

    public function render()
    {
        return view('livewire.document-dashboard.overview')
            ->layout('layouts.guest');
    }
}
