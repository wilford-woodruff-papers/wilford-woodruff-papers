<?php

namespace App\View\Components;

use App\Models\Testimonial;
use App\Models\VideoTestimonial;
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
            'featuredTestimony' => Cache::remember('featured-testimony', 3600, function () {
                return VideoTestimonial::query()
                    ->select('id', 'slug', 'name', 'excerpt', 'type', 'video')
                    ->whereNotNull('excerpt')
                    ->inRandomOrder()
                    ->limit(1)
                    ->first();
            }),
            'testimonies' => Cache::remember('new-testimonies', 3600, function () {
                return Testimonial::query()
                    ->select('id', 'slug', 'name', 'content')
                    ->whereNotNull('content')
                    ->with('media')
                    ->has('media')
                    ->limit(5)
                    ->inRandomOrder()
                    ->get();
            }),
        ]);
    }
}
