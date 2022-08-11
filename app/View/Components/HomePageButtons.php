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
                'description' => 'Search the Papers',
                'link' => route('landing-areas.search'),
            ],
            [
                'image' => asset('img/home/people.jpg'),
                'title' => 'Ponder',
                'description' => 'Learn how the writings apply to your life:<br />connect & explore',
                'link' => route('landing-areas.ponder'),
            ],
            [
                'image' => asset('img/home/places.jpg'),
                'title' => 'Serve',
                'description' => 'Get involved in the Project',
                'link' => route('get-involved.index'),
            ],
            [
                'image' => asset('img/home/historical-context.jpg'),
                'title' => 'Testify',
                'description' => 'Share your experience with the Papers',
                'link' => route('testimonies.index'),
            ],
        ];

        return view('components.home.buttons', [
            'pages' => $pages,
        ]);
    }
}
