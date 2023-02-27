<?php

namespace App\Http\Livewire\Admin;

use App\Models\Item;
use App\Models\Page;
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
                        $query->where('enabled', false)->whereNotNull('ftp_slug');
                    })
                    ->count() - Page::query()
                        ->whereHas('item', function ($query) {
                            $query->whereNull('type_id');
                        })
                        ->count(),
                'total_found' => Item::query()
                        ->where(function ($query) {
                            $query->where('auto_page_count', '<=', 0)
                                ->orWhereNull('auto_page_count');
                        })
                        ->sum('manual_page_count')
                    + Item::query()
                        ->where('auto_page_count', '>', 0)
                        ->sum('auto_page_count')
                    + Item::query()
                        ->where('missing_page_count', '>', 0)
                        ->sum('missing_page_count'),

            ];
        }

        return view('livewire.admin.progress-graphic', [
            'pageStats' => $pageStats ?? [],

        ])
            ->layout('layouts.admin');
    }

    public function loadStats()
    {
        $this->readyToLoad = true;
    }
}
