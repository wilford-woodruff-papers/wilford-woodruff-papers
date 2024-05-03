<?php

namespace App\Http\Controllers;

use App\Models\ComeFollowMe;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ComeFollowMeShowController extends Controller
{
    public function __invoke(Request $request, $book = null, $week = null)
    {
        if ($week > now('America/Denver')->week || $week > 52) {
            return redirect()->route('come-follow-me.index');
        }

        if (empty($book)) {
            $year = substr(now()->year, -1) % 4;

            $book = match ($year) {
                0 => 'book-of-mormon',
                1 => 'doctrine-and-covenants',
                2 => 'old-testament',
                3 => 'new-testament',
            };
        }

        $bookName = match ($book) {
            'book-of-mormon' => 'Book of Mormon',
            'doctrine-and-covenants' => 'Doctrine & Covenants',
            'new-testament' => 'New Testament',
            'old-testament' => 'Old Testament',
        };

        $churchLink = match ($book) {
            'book-of-mormon' => 'https://www.churchofjesuschrist.org/study/manual/come-follow-me-for-home-and-church-book-of-mormon-2024/',
            'doctrine-and-covenants' => 'https://www.churchofjesuschrist.org/study/manual/come-follow-me-for-home-and-church-doctrine-and-covenants-2025/',
            'new-testament' => 'https://www.churchofjesuschrist.org/study/manual/come-follow-me-for-home-and-church-new-testament-2026/',
            'old-testament' => 'https://www.churchofjesuschrist.org/study/manual/come-follow-me-for-home-and-church-old-testament-2027/',
        };

        $churchLink .= str_pad($week, 2, '0', STR_PAD_LEFT);

        try {
            $lesson = ComeFollowMe::where('book', $bookName)
                ->with([
                    'events.page.parent',
                ])
                ->where('week', $week)
                ->firstOrFail();

            $previousCount = 2;
            $nextCount = 2;

            $previous = ComeFollowMe::where('book', $bookName)
                ->where('week', '<', $week)
                ->orderBy('week', 'DESC')
                ->limit($previousCount)
                ->get()
                ->reverse();

            $next = ComeFollowMe::where('book', $bookName)
                ->where('week', '>', $week)
                ->where('week', '<=', now('America/Denver')->week)
                ->orderBy('week', 'ASC')
                ->limit(max($nextCount, 4 - $previous->count()))
                ->get();

            return view('public.come-follow-me.show', [
                'lesson' => $lesson,
                'bookSlug' => $book,
                'previous' => $previous,
                'next' => $next,
                'churchLink' => $churchLink,
            ]);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('come-follow-me.index');
        }

    }
}
