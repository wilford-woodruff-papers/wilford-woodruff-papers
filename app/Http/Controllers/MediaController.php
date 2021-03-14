<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Press;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function photos(Request $request)
    {
        return view('public.media.photos', [
            'photos' => Photo::paginate(18),
        ]);
    }

    public function photo(Request $request, Photo $photo)
    {
        return view('public.media.photo', [
            'photo' => $photo,
        ]);
    }

    public function podcasts(Request $request)
    {
        return view('public.media.podcasts', [
            'podcasts' => Press::whereType('PODCAST')
                                    ->orderBy('date', 'DESC')
                                    ->get(),
        ]);
    }

    public function videos(Request $request)
    {
        return view('public.media.videos', [
            'videos' => Press::whereType('VIDEO')
                                ->orderBy('date', 'DESC')
                                ->orderBy('title', 'ASC')
                                ->get(),
        ]);
    }

    public function newsroom(Request $request)
    {
        return view('public.media.newsroom', [
            'articles' => Press::whereType('NEWS')
                                ->orderBy('date', 'DESC')
                                ->get(),
        ]);
    }

    public function kit(Request $request)
    {
        return view('public.media.media-kit');
    }

    public function requests(Request $request)
    {
        return view('public.media.requests');
    }
}
