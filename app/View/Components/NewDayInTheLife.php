<?php

namespace App\View\Components;

use App\Models\Page;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Date;
use Illuminate\View\Component;

class NewDayInTheLife extends Component
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
        $month = now('America/Denver')->month;
        $day = now('America/Denver')->day;
        // dd($year, $month, $day);
        $date = Date::createFromFormat('Y-m-d',
            \App\Models\Date::query()
                ->select('date')
                ->whereMonth('date', $month)
                ->whereDay('date', $day)
                ->where('dateable_type', Page::class)
                ->whereHasMorph('dateable', Page::class, function ($query) {
                    $query->whereRelation('parent', 'type_id', 5);
                })
                ->inRandomOrder()
                ->toBase()
                ->first()
                ?->date);

        $pages = Page::query()
            ->with([
                'media',
            ])
            ->whereRelation('parent', 'type_id', 5)
            ->whereRelation('dates', 'date', $date->toDateString())
            ->whereHas('parent')
            ->orderBy('order', 'asc')
            ->get();

        $content = $pages
            ->map(function ($entry) use ($date) {
                return str($entry->transcript)
                    ->extractContentOnDate($date);
            })
            ->join("\n");

        return view('components.new-day-in-the-life', [
            'date' => $date,
            'image' => $pages->first()->getFirstMedia()?->getUrl('thumb'),
            'pages' => $pages,
            'content' => $content,
        ]);
    }
}
