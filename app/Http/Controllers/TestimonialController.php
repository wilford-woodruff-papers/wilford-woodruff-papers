<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\View\View;

class TestimonialController extends Controller
{
    public function index(): View
    {
        $featured = Testimonial::query()
                                ->whereFeatured(1)
                                ->latest()
                                ->limit(10)
                                ->get();

        if ($featured->count() > 0) {
            $featured->prepend($featured->pop());
        }

        $testimonials = Testimonial::query()
                            ->whereNotIn('id', array_merge(
                                $images->pluck('id')->all(),
                                $videos->pluck('id')->all(),
                            ))
                            ->latest()
                            ->get();

        return view('public.landing-areas.testimonials', [
            'videos' => $videos,
            'images' => $images,
            'testimonials' => $testimonials,
        ]);
    }
}
