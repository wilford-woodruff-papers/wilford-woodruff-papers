<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CallToAction extends Component
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
        $links = [
            [
                'image' => 'https://wilford-woodruff-papers.nyc3.digitaloceanspaces.com/245/conversions/82-CHL-PH-1872_b0000_f0001_i0001_00001-Valley-House-Hotel-9-1908-cropped-thumb.jpg',
                'title' => 'Get Involved',
                'link' => route('get-involved.index'),
            ],
            [
                'image' => 'https://wilford-woodruff-papers.nyc3.digitaloceanspaces.com/246/conversions/Woodruff-Home-in-Nauvoo-LOC-thumb.jpg',
                'title' => 'Donate Now',
                'link' => route('donate.online'),
            ],
            [
                'image' => 'https://wilford-woodruff-papers.nyc3.digitaloceanspaces.com/243/conversions/WW-July-24-1898-in-Pioneer-Park-thumb.jpg',
                'title' => 'Sign Up for Updates',
                'link' => 'https://updates.wilfordwoodruffpapers.org/posts',
            ],
            [
                'image' => 'https://wilfordwoodruffpapers.org/img/banners/home.jpg',
                'title' => 'Contribute Documents',
                'link' => route('contribute-documents'),
            ],
        ];

        return view('components.home.call-to-action', [
            'links' => $links,
        ]);
    }
}
