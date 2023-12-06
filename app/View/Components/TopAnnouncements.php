<?php

namespace App\View\Components;

use App\Models\Announcement;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class TopAnnouncements extends Component
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
        $announcements = Cache::remember('top-announcements', 3600, function () {
            return Announcement::query()
                ->where('type', 'homepage_top')
                ->where('start_publishing_at', '<', now('America/Denver'))
                ->where('end_publishing_at', '>', now('America/Denver'))
                ->orderBy('order_column', 'ASC')
                ->orderBy('end_publishing_at', 'ASC')
                ->get();
        });

        return view('components.announcements', [
            'announcements' => $announcements,
            'position' => 'top',
        ]);
    }
}
