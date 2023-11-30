<?php

namespace App\Livewire;

use App\Models\Testimonial;
use Livewire\Component;

class Testimonials extends Component
{
    public $filters = [
        'search' => null,
        'type' => [],
    ];

    public $perPage = 10;

    protected $queryString = ['filters'];

    protected $rules = [
        'filters' => 'max:100',
    ];

    public $showTestimony;

    public function mount()
    {
        if ($slug = request()->get('testimony')) {
            $this->showTestimony = Testimonial::query()
                ->where('slug', $slug)
                ->first();
        }
    }

    public function render()
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
            ->whereNotIn('id', $featured->pluck('id')->all())
            ->latest()
            ->paginate($this->perPage);

        return view('public.landing-areas.testimonials', [
            'featured' => $featured,
            'testimonials' => $testimonials,
        ])
            ->layout('layouts.guest');
    }

    public function loadMore()
    {
        $this->perPage += 10;
    }
}
