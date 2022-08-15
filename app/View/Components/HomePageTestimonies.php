<?php

namespace App\View\Components;

use App\Models\Testimonial;
use Illuminate\View\Component;

class HomePageTestimonies extends Component
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
        return view('components.home.testimonies', [
            'testimonies' => Testimonial::query()
                                            ->select('id', 'slug', 'name')
                                            ->with('media')
                                            ->has('media')
                                            ->limit(8)
                                            ->inRandomOrder()
                                            ->get(),
        ]);
    }
}
