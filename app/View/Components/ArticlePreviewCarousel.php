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
        return view('components.article-preview-carousel', [
            'medias' => Press::select('id', 'type', 'title', 'cover_image', 'slug')
                                ->whereNotNull('cover_image')
                                ->limit(6)
                                ->orderBy('created_at', 'DESC')
                                ->get(),
        ]);
    }
}
