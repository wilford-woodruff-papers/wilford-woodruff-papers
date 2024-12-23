<?php

namespace App\Http\Controllers;

use App\Models\ComeFollowMe;
use Illuminate\Http\Request;

class ComeFollowMeIndexController extends Controller
{
    public function __invoke(Request $request, $book = null)
    {
        if (empty($book)) {
            $year = substr(now()->year, -1) % 4;

            $request->merge([
                'book' => match ($year) {
                    0 => 'book-of-mormon',
                    1 => 'doctrine-and-covenants',
                    2 => 'old-testament',
                    3 => 'new-testament',
                },
            ]);
        } else {
            $request->merge([
                'book' => $book,
            ]);
        }
        $bookSlug = $request->get('book');
        $book = match ($bookSlug) {
            'book-of-mormon' => 'Book of Mormon',
            'doctrine-and-covenants' => 'Doctrine and Covenants',
            'new-testament' => 'New Testament',
            'old-testament' => 'Old Testament',
        };

        $lessons = ComeFollowMe::query()
            ->where('book', $book)
            ->where('week', '<=', now('America/Denver')->week)
            ->orderBy('week', 'desc')
            ->get();

        return view('public.come-follow-me.index', [
            'book' => $book,
            'bookSlug' => $bookSlug,
            'cfm' => $lessons->shift(),
            'lessons' => $lessons,
        ]);
    }
}
