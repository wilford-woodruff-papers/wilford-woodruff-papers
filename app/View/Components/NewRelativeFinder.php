<?php

namespace App\View\Components;

use App\Models\Subject;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class NewRelativeFinder extends Component
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
        return view('components.new-relative-finder', [
            'image' => Subject::query()
                ->people()
                ->whereNotNull('portrait')
                ->where('portrait', 'LIKE', 'https://tree-portraits-bgt.familysearchcdn.org%')
                ->inRandomOrder()
                ->first()
                ->portrait,
        ]);
    }
}
