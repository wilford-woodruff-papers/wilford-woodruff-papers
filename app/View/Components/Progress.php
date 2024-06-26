<?php

namespace App\View\Components;

use App\Models\QuarterlyUpdate;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class Progress extends Component
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
        return view('components.home.progress', [
            'quarterlyUpdate' => Cache::remember('quarterly-update', 3600, function () {
                return QuarterlyUpdate::query()
                    ->where('enabled', 1)
                    ->orderBy('publish_at', 'DESC')
                    ->first();
            }),
        ]);
    }
}
