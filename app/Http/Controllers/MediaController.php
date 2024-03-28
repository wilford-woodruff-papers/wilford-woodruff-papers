<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\News;
use App\Models\Photo;
use App\Models\Podcast;
use App\Models\Press;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class MediaController extends Controller
{
    public function articles(Request $request): View
    {
        return view('public.media.articles', [
            'articles' => Article::query()
                ->with([
                    'tags',
                    'authors',
                ])
                ->latest('date')
                ->whereDate('date', '<=', DB::raw('NOW()'))
                ->when($request->has('tag'), function ($query) use ($request) {
                    $query->withAnyTags($request->get('tag'), 'articles');
                })
                ->paginate(10),
        ]);
    }

    public function article(Request $request, Press $article): View
    {
        return view('public.media.article', [
            'article' => $article,
        ]);
    }

    public function photos(Request $request): View
    {
        return view('public.media.photos', [
            'photos' => Photo::query()
                ->with([
                    'tags',
                ])
                ->when($request->has('tag'), function ($query) use ($request) {
                    $query->withAnyTags($request->get('tag'), 'photos');
                })
                ->paginate(18),
        ]);
    }

    public function photo(Request $request, Photo $photo): View
    {
        $photo->load([
            'events',
        ]);

        return view('public.media.photo', [
            'photo' => $photo,
        ]);
    }

    public function podcasts(Request $request): View
    {
        return view('public.media.podcasts', [
            'podcasts' => Podcast::query()
                ->latest('date')
                ->with([
                    'tags',
                ])
                ->paginate(10),
        ]);
    }

    public function podcast(Request $request, Press $podcast): View
    {
        return view('public.media.podcast', [
            'podcast' => $podcast,
        ]);
    }

    public function videos(Request $request): View
    {
        return view('public.media.videos', [
            'videos' => Video::query()
                ->with([
                    'tags',
                ])
                ->latest('date')
                ->whereDate('date', '<=', DB::raw('NOW()'))
                ->orderBy('title', 'ASC')
                ->when($request->has('tag'), function ($query) use ($request) {
                    $query->withAnyTags($request->get('tag'), 'videos');
                })
                ->paginate(10),
        ]);
    }

    public function video(Request $request, Press $video): View
    {
        return view('public.media.video', [
            'video' => $video,
        ]);
    }

    public function instagram(Request $request, Press $instagram): View
    {
        return view('public.media.instagram', [
            'instagram' => $instagram,
        ]);
    }

    public function newsroom(Request $request): View
    {
        return view('public.media.newsroom', [
            'articles' => News::latest('date')
                ->paginate(10),
        ]);
    }

    public function kit(Request $request): View
    {
        return view('public.media.media-kit');
    }

    public function requests(Request $request): View
    {
        return view('public.media.requests');
    }

    public function copyright(Request $request): View
    {
        return view('public.media.copyright');
    }
}
