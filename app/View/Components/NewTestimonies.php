<?php

namespace App\View\Components;

use App\Models\Testimonial;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class NewTestimonies extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.new-testimonies', [
            'testimonies' => Cache::remember('new-testimonies', 3600, function () {
                return Testimonial::query()
                    ->select('id', 'slug', 'name', 'content')
                    ->with('media')
                    ->has('media')
                    ->limit(6)
                    ->inRandomOrder()
                    ->get();
            }),
        ]);
    }
}
