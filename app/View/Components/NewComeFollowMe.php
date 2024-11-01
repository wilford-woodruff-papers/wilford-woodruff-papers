<?php

namespace App\View\Components;

use App\Models\ComeFollowMe;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class NewComeFollowMe extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $year = substr(now()->year, -1) % 4;

        request()->merge([
            'book' => match ($year) {
                0 => 'book-of-mormon',
                1 => 'doctrine-and-covenants',
                2 => 'old-testament',
                3 => 'new-testament',
            },
        ]);

        $bookSlug = request()->get('book');
        $book = match ($bookSlug) {
            'book-of-mormon' => 'Book of Mormon',
            'doctrine-and-covenants' => 'Doctrine & Covenants',
            'new-testament' => 'New Testament',
            'old-testament' => 'Old Testament',
        };

        $lessons = ComeFollowMe::query()
            ->where('book', $book)
            ->where('week', '<=', now('America/Denver')->week)
            ->orderBy('week', 'desc')
            ->get();

        return view('components.new-come-follow-me', [
            'book' => $book,
            'bookSlug' => $bookSlug,
            'cfm' => $lessons->shift(),
            'lessons' => $lessons,
        ]);
    }
}
