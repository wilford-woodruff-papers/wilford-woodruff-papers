<?php

namespace App\Livewire\Admin;

use App\Models\Item;
use App\Models\Page;
use App\Models\Quote;
use App\Models\Subject;
use Livewire\Component;

class ProgressGraphic extends Component
{
    public $readyToLoad = false;

    public function render()
    {
        if ($this->readyToLoad) {
            $pageStats = [
                'published' => Page::query()
                    ->whereHas('item', function ($query) {
                        $query->where('enabled', true);
                    })
                    ->count(),
                'identified' => Item::query()
                    ->whereNotNull('type_id')
                    ->whereDoesntHave('items')
                    ->where(function ($query) {
                        $query->where('auto_page_count', '<=', 0)
                            ->orWhereNull('auto_page_count');
                    })
                    ->sum('manual_page_count')
                    + Item::query()
                        ->where('missing_page_count', '>', 0)
                        ->sum('missing_page_count'),
                'in_progress' => Page::query()
                    ->whereHas('item', function ($query) {
                        $query->where('enabled', false)
                            ->whereNotNull('type_id')
                            ->whereNotNull('ftp_slug');
                    })->count(),
                'total_found' => Item::query()
                    ->whereNotNull('type_id')
                    ->whereDoesntHave('items')
                    ->where(function ($query) {
                        $query->where('auto_page_count', '<=', 0)
                            ->orWhereNull('auto_page_count');
                    })
                    ->sum('manual_page_count')
                    + Item::query()
                        ->whereNotNull('type_id')
                        ->whereDoesntHave('items')
                        ->where('auto_page_count', '>', 0)
                        ->sum('auto_page_count')
                    + Item::query()
                        ->where('missing_page_count', '>', 0)
                        ->sum('missing_page_count'),

            ];

            $bioStats = [
                'total_bios_approved' => Subject::query()
                    ->people()
                    ->whereNotNull('bio_approved_at')
                    ->count(),
                'total_identified_people' => Subject::query()
                    ->people()
                    ->whereNotNull('pid')
                    ->count(),
                'total_people' => Subject::query()
                    ->people()
                    ->count(),
            ];

            $placeStats = [
                'total_identified_places' => Subject::query()
                    ->places()
                    ->whereNotNull('place_confirmed_at')
                    ->count(),
                'total_places' => Subject::query()
                    ->places()
                    ->count(),
            ];

            $quoteStats = [
                'total_tagged_quotes' => Quote::query()
                    ->whereNull('continued_from_previous_page')
                    ->count(),
            ];
        }

        return view('livewire.admin.progress-graphic', [
            'pageStats' => $pageStats ?? [],
            'bioStats' => $bioStats ?? [],
            'placeStats' => $placeStats ?? [],
            'quoteStats' => $quoteStats ?? [],

        ])
            ->layout('layouts.admin');
    }

    public function loadStats()
    {
        $this->readyToLoad = true;
    }
}
