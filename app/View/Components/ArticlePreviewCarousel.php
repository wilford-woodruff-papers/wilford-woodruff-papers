<?php

namespace App\View\Components;

use App\Models\Press;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Component;

class ArticlePreviewCarousel extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $instagram = Cache::remember('first-instagram', 3600, function () {
            return Press::query()
                ->select('id', 'type', 'title', 'cover_image', 'slug', 'date', 'subtitle', 'excerpt')
                ->hasCoverImage()
                ->where('type', 'Instagram')
                ->orderBy('date', 'DESC')
                ->first();
        });

        return view('components.home.article-preview-carousel', [
            'medias' => Cache::remember('top-press', 3600, function () {
                return Press::query()
                    ->select('id', 'type', 'title', 'cover_image', 'slug', 'date', 'subtitle', 'excerpt')
                    ->hasCoverImage()
                    ->whereDate('date', '<=', DB::raw('NOW()'))
                    ->where('type', '!=', 'Instagram')
                    ->limit(5)
                    ->orderBy('date', 'DESC')
                    ->get();
            })
                ->when($instagram, function ($collection, $instagram) {
                    return $collection->prepend($instagram);
                }),
        ]);
    }
}
