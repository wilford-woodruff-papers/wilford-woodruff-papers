<?php

namespace App\Http\Controllers;

use App\Models\ComeFollowMe;
use App\src\OgImageGenerator;
use Illuminate\Http\Request;

class ComeFollowMeLessonOgImageController extends Controller
{
    public function __invoke(Request $request, $book = null, $week = null)
    {
        $bookName = match ($book) {
            'book-of-mormon' => 'Book of Mormon',
            'doctrine-and-covenants' => 'Doctrine & Covenants',
            'new-testament' => 'New Testament',
            'old-testament' => 'Old Testament',
        };

        $lesson = ComeFollowMe::where('book', $bookName)
            ->where('week', $week)
            ->firstOrFail();

        $image = cache()->rememberForever('lessons.'.$lesson->id.'.ogimage', function () use ($lesson) {
            return (new OgImageGenerator())->render(
                view('public.come-follow-me.lesson-og-image')
                    ->with([
                        'lesson' => $lesson,
                    ])
                    ->render()
            );
        });

        return response($image)
            ->header('Content-Type', 'image/png');
    }
}
