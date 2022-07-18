<?php

namespace App\Http\Controllers;

use App\Models\ImageTestimonial;
use App\Models\Testimonial;
use App\Models\VideoTestimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index()
    {
        $videos = VideoTestimonial::query()
            ->whereFeatured(1)
            ->latest()
            ->limit(6)
            ->get();
        if($videos->count() > 0) {
            $videos->prepend($videos->pop());
        }

        $images = ImageTestimonial::query()
            ->whereFeatured(1)
            ->latest()
            ->limit(3)
            ->get();

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
