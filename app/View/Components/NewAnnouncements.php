<?php

namespace App\View\Components;

use App\Models\Announcement;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class NewAnnouncements extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $announcements = Cache::remember('new-top-announcements', 3600, function () {
            return Announcement::query()
                ->where('type', 'homepage_top')
                ->where('start_publishing_at', '<', now('America/Denver'))
                ->where(function ($query) {
                    $query->whereNull('end_publishing_at')
                        ->orWhere('end_publishing_at', '>', now('America/Denver'));
                })
                ->orderBy('order_column', 'ASC')
                ->orderBy('end_publishing_at', 'ASC')
                ->get();
        });

        return view('components.new-announcements', [
            'announcements' => $announcements,
            'position' => 'top',
        ]);
    }
}
