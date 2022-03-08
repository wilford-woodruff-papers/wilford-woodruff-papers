<?php

namespace App\View\Components;

use App\Models\Announcement;
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
        $now = now('America/Denver');
        return view('components.announcements', [
            'announcements' => Announcement::query()
                                ->where('type', 'homepage_top')
                                ->where('start_publishing_at', '<', $now)
                                ->where('end_publishing_at', '>', $now)
                                ->orderBy('end_publishing_at', 'ASC')
                                ->get(),
        ]);
    }
}
