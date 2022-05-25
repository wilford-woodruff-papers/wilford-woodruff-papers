<?php

namespace App\View\Components;

use App\Models\Press;
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
        return view('components.home.article-preview-carousel', [
            'medias' => Press::select('id', 'type', 'title', 'cover_image', 'slug', 'date', 'subtitle', 'excerpt')
                                ->whereNotNull('cover_image')
                                ->limit(6)
                                ->orderBy('date', 'DESC')
                                ->get(),
        ]);
    }
}
