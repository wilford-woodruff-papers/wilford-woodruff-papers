<?php

namespace App\View\Components\Testimonials;

use Illuminate\View\Component;

class ImageGridTestimonials extends Component
{
    public $testimonials;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($testimonials)
    {
        $this->testimonials = $testimonials;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.testimonials.image-grid-testimonials');
    }
}
