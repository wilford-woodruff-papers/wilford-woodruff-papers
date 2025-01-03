<?php

namespace App\Http\Controllers;

use App\Models\ComeFollowMe;
use Illuminate\Http\Request;

class ComeFollowMeIndexController extends Controller
{
    public function __invoke(Request $request, $book = null)
    {
        if (empty($book)) {
            //$year = substr(now()->year, -1) % 4;
            $year = 1;

            $request->merge([
                'book' => match ($year) {
                    0 => 'book-of-mormon',
                    1 => 'doctrine-and-covenants',
                    2 => 'old-testament',
                    3 => 'new-testament',
                },
            ]);
        } else {
            $year = 1;
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

        $bookYear = match ($bookSlug) {
            'book-of-mormon' => 0,
            'doctrine-and-covenants' => 1,
            'new-testament' => 2,
            'old-testament' => 3,
        };
        //dd($bookYear, $year);
        $lessons = ComeFollowMe::query()
            ->where('book', $book)
            ->when(($bookYear == $year), function ($query) {
                return $query->where('week', '<=', now('America/Denver')->week);
            })
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
