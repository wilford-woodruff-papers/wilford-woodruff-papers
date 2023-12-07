<?php

namespace App\View\Components;

use App\Models\Announcement;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class BottomAnnouncements extends Component
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
        $now = now('America/Denver');

        return view('components.announcements', [
            'announcements' => Cache::remember('bottom-announcements', 3600, function () use ($now) {
                return Announcement::query()
                    ->where('type', 'homepage_bottom')
                    ->where('start_publishing_at', '<', $now)
                    ->where('end_publishing_at', '>', $now)
                    ->orderBy('order_column', 'ASC')
                    ->orderBy('end_publishing_at', 'ASC')
                    ->get();
            }),
            'position' => 'bottom',
        ]);
    }
}
