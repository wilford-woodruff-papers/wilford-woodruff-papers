<?php

namespace App\View\Components;

use Illuminate\View\Component;

class PonderPageButtons extends Component
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
                'title' => 'Documents',
                'link' => route('documents'),
            ],
            [
                'image' => asset('img/home/people.jpg'),
                'title' => 'People',
                'link' => route('people'),
            ],
            [
                'image' => asset('img/home/places.jpg'),
                'title' => 'Places',
                'link' => route('places'),
            ],
            [
                'image' => asset('img/home/historical-context.jpg'),
                'title' => 'Timeline',
                'link' => route('timeline'),
            ],
        ];

        return view('components.home.buttons', [
            'pages' => $pages,
            'textSize' => 'text-xl md:text-3xl',
            'buttonSize' => 'w-32 h-32 md:h-48 md:w-48',
        ]);
    }
}
