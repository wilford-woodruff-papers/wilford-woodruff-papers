<?php

namespace App\View\Components;

use Illuminate\View\Component;

class HomePageButtons extends Component
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
        $pages = [
            [
                'image' => asset('img/home/documents.jpg'),
                'title' => 'Search',
                'link' => route('landing-areas.search'),
            ],
            [
                'image' => asset('img/home/people.jpg'),
                'title' => 'Ponder',
                'link' => route('landing-areas.ponder'),
            ],
            [
                'image' => asset('img/home/places.jpg'),
                'title' => 'Serve',
                'link' => route('landing-areas.serve'),
            ],
            [
                'image' => asset('img/home/historical-context.jpg'),
                'title' => 'Testify',
                'link' => route('landing-areas.testify'),
            ],
        ];

        return view('components.home.buttons', [
            'pages' => $pages,
        ]);
    }
}
