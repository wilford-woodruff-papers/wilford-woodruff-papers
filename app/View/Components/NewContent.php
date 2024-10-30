<?php

namespace App\View\Components;

use App\Models\Press;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Component;

class NewContent extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $instagram = Cache::remember('new-content-instagram', 3600, function () {
            return Press::query()
                ->select('id', 'type', 'title', 'cover_image', 'slug', 'date', 'subtitle', 'excerpt')
                ->hasCoverImage()
                ->where('type', 'Instagram')
                ->orderBy('date', 'DESC')
                ->first();
        });

        $medias = Cache::remember('new-content', 3600, function () {
            return Press::query()
                ->select('id', 'type', 'title', 'cover_image', 'slug', 'date', 'subtitle', 'excerpt')
                ->hasCoverImage()
                ->whereDate('date', '<=', DB::raw('NOW()'))
                ->where('type', '!=', 'Instagram')
                ->limit(2)
                ->orderBy('date', 'DESC')
                ->get();
        });

        return view('components.new-content', [
            'instagram' => $instagram,
            'medias' => $medias,
        ]);
    }
}
