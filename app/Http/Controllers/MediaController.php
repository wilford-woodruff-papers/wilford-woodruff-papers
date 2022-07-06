<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\News;
use App\Models\Photo;
use App\Models\Podcast;
use App\Models\Press;
use App\Models\Video;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function articles(Request $request)
    {
        return view('public.media.articles', [
            'articles' => Article::latest('date')
                                    ->paginate(10),
        ]);
    }

    public function article(Request $request, Press $article)
    {
        return view('public.media.article', [
            'article' => $article,
        ]);
    }

    public function photos(Request $request)
    {
        return view('public.media.photos', [
            'photos' => Photo::query()
                                ->when($request->has('tag'), function ($query) use ($request) {
                                    $query->withAnyTags($request->get('tag'), 'photos');
                                })->paginate(18),
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
            'podcasts' => Podcast::latest('date')
                                    ->paginate(10),
        ]);
    }

    public function podcast(Request $request, Press $podcast)
    {
        return view('public.media.podcast', [
            'podcast' => $podcast,
        ]);
    }

    public function videos(Request $request)
    {
        return view('public.media.videos', [
            'videos' => Video::latest('date')
                                ->orderBy('title', 'ASC')
                                ->when($request->has('tag'), function ($query) use ($request) {
                                    $query->withAnyTags($request->get('tag'), 'videos');
                                })
                                ->paginate(10),
        ]);
    }

    public function video(Request $request, Press $video)
    {
        return view('public.media.video', [
            'video' => $video,
        ]);
    }

    public function newsroom(Request $request)
    {
        return view('public.media.newsroom', [
            'articles' => News::latest('date')
                                ->paginate(10),
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
