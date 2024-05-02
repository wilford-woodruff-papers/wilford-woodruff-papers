<?php

namespace App\Http\Controllers;

use App\Models\ComeFollowMe;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ComeFollowMeShowController extends Controller
{
    public function __invoke(Request $request)
    {
        if (! $request->has('book')) {
            $year = substr(now()->year, -1) % 4;

            $request->merge([
                'book' => match ($year) {
                    0 => 'book-of-mormon',
                    1 => 'doctrine-and-covenants',
                    2 => 'old-testament',
                    3 => 'new-testament',
                },
            ]);
        }

        $book = match ($request->get('book')) {
            'book-of-mormon' => 'Book of Mormon',
            'doctrine-and-covenants' => 'Doctrine & Covenants',
            'new-testament' => 'New Testament',
            'old-testament' => 'Old Testament',
        };

        try {
            $cfm = ComeFollowMe::where('book', $book)
                ->where('week', $request->get('week'))
                ->firstOrFail();

            return view('public.come-follow-me.show', [
                'cfm' => $cfm,
            ]);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('come-follow-me.index');
        }

    }
}
