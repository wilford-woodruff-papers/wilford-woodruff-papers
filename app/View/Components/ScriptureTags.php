<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ScriptureTags extends Component
{
    protected $volumeMap = [
        'ot' => 'Old Testament',
        'nt' => 'New Testament',
        'bofm' => 'Book of Mormon',
        'dc-testament' => 'Doctrine and Covenants',
    ];

    /**
     * Create a new component instance.
     */
    public function __construct(public string $text)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $volumes = [];

        $matches = str($this->text)->matchAll(
            "/(?<=(?<=\[|\s)##)(.*)(?=##(?=\]|\s))/mU"
        );

        foreach ($matches as $match) {
            $match = strip_tags(
                str($match)
                    ->explode('|')
                    ->first()
            );
            $book = str($match)
                ->match("/([1-9]*\s?[A-Za-z\s—]+)/s")
                ->trim()
                ->toString();
            $volumes[$this->volumeMap[getVolume($book)]][] = $match;

        }

        ksort($volumes);

        return view('components.scripture-tags', [
            'volumes' => $volumes,
        ]);
    }
}
