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
                'image' => 'https://picsum.photos/300/300',
                'title' => 'Volunteer Today',
                'link' => route('volunteer'),
            ],
            [
                'image' => 'https://picsum.photos/300/300',
                'title' => 'Donate Now',
                'link' => route('donate.online'),
            ],
            [
                'image' => 'https://picsum.photos/300/300',
                'title' => 'Sign Up for Updates',
                'link' => 'https://updates.wilfordwoodruffpapers.org/posts',
            ],
        ];

        return view('components.home.call-to-action', [
            'links' => $links,
        ]);
    }
}
