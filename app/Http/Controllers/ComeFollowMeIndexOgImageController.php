<?php

namespace App\Http\Controllers;

use App\Models\ComeFollowMe;
use App\src\OgImageGenerator;
use Illuminate\Http\Request;

class ComeFollowMeIndexOgImageController extends Controller
{
    public function __invoke(Request $request, $bookSlug = null)
    {
        if (empty($bookSlug)) {
            $year = substr(now()->year, -1) % 4;

            $bookSlug = match ($year) {
                0 => 'book-of-mormon',
                1 => 'doctrine-and-covenants',
                2 => 'old-testament',
                3 => 'new-testament',
            };
        }
        $book = match ($bookSlug) {
            'book-of-mormon' => 'Book of Mormon',
            'doctrine-and-covenants' => 'Doctrine & Covenants',
            'new-testament' => 'New Testament',
            'old-testament' => 'Old Testament',
        };

        $image = cache()->rememberForever('year.'.$bookSlug.'.ogimage', function () use ($book) {
            return (new OgImageGenerator())->render(
                view('public.come-follow-me.index-og-image')
                    ->with([
                        'bookName' => $book,
                        'image' => ComeFollowMe::firstWhere('book', $book)->getFirstMediaUrl('cover_image'),
                    ])
                    ->render()
            );
        });

        return response($image)
            ->header('Content-Type', 'image/png');
    }
}
