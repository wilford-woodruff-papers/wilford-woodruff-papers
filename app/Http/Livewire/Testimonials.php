<?php

namespace App\Http\Livewire;

use App\Models\Press;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Maize\Markable\Models\Like;

class Testimonials extends Component
{

    public $perPage = 10;

    public $filters = [
        'search' => null,
        'type' => [],
    ];

    protected $queryString = ['filters'];

    protected $rules = [
        'filters' => 'max:100',
    ];

    public function mount()
    {
        //
    }

    public function render()
    {
        $featured = Testimonial::query()
                                    ->whereFeatured(1)
                                    ->latest()
                                    ->limit(10)
                                    ->get();

        if($featured->count() > 0) {
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
