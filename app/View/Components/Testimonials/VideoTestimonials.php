<?php

namespace App\View\Components\Testimonials;

use Illuminate\View\Component;

class VideoTestimonials extends Component
{
    public $videos;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($videos)
    {
        $this->videos = $videos;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.testimonials.video-testimonials');
    }
}
