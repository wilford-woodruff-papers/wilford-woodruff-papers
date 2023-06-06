<?php

namespace App\Http\Livewire\Admin;

use App\Models\Item;
use App\Models\Page;
use App\Models\Quote;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Builder;
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
                        ->where(function ($query) {
                            $query->where('auto_page_count', '<=', 0)
                                ->orWhereNull('auto_page_count');
                        })
                        ->sum('manual_page_count')
                    + Item::query()
                        ->whereNotNull('type_id')
                        ->where('auto_page_count', '>', 0)
                        ->sum('auto_page_count')
                    + Item::query()
                        ->where('missing_page_count', '>', 0)
                        ->sum('missing_page_count'),

            ];

            $bioStats = [
                'total_identified_people' => Subject::query()
                    ->whereHas('category', function (Builder $query) {
                        $query->where('name', 'People');
                    })
                    ->whereNotNull('pid_identified_at')
                    ->count(),
                'total_identified_places' => Subject::query()
                    ->whereHas('category', function (Builder $query) {
                        $query->where('name', 'Places');
                    })
                    ->whereNotNull('place_confirmed_at')
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
            'quoteStats' => $quoteStats ?? [],

        ])
            ->layout('layouts.admin');
    }

    public function loadStats()
    {
        $this->readyToLoad = true;
    }
}
