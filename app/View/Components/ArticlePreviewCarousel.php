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
        $instagram = Press::select('id', 'type', 'title', 'cover_image', 'slug', 'date', 'subtitle', 'excerpt')
                            ->where('type', 'Instagram')
                            ->whereNotNull('cover_image')
                            ->orderBy('date', 'DESC')
                            ->first();
        return view('components.home.article-preview-carousel', [
            'medias' => Press::select('id', 'type', 'title', 'cover_image', 'slug', 'date', 'subtitle', 'excerpt')
                                ->where('type', '!=', 'Instagram')
                                ->whereNotNull('cover_image')
                                ->limit(5)
                                ->orderBy('date', 'DESC')
                                ->get()
                                ->when($instagram, function ($collection, $instagram) {
                                    return $collection->prepend($instagram);
                                }),
        ]);
    }
}
