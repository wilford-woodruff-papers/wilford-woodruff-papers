<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\View;

class DayInTheLifeBannerController extends Controller
{
    public function __invoke(Request $request, int $month, int $day, ?int $year = null)
    {
        $month = $month ?? now('America/Denver')->month;
        $day = $day ?? now('America/Denver')->day;
        // dd($year, $month, $day);
        $date = Date::createFromFormat('Y-m-d',
            \App\Models\Date::query()
                ->select('date')
                ->when($year, function (Builder $query, int $year) {
                    $query->whereYear('date', $year);
                })
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

        $day = Page::query()
            ->with([
                'parent',
                'quotes',
                'media',
            ])
            ->whereRelation('parent', 'type_id', 5)
            ->whereRelation('dates', 'date', $date->toDateString())
            ->whereHas('parent')
            ->orderBy('order', 'asc')
            ->get();

        $content = $day
            ->map(function ($entry) use ($date) {
                return str($entry->transcript)
                    ->extractContentOnDate($date);
            })
            ->join("\n");

        $subjects = Subject::extractFromText($content);

        $types = collect([]);

        $people = $subjects->get('People')
            ?->sortBy('name');
        $places = $subjects->get('Places')
            ?->sortBy('name');
        $topics = $subjects->get('Index')
            ?->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE);

        if (! empty($people) && $people->count() > 4) {
            $types->push('people');
        }
        if (! empty($day) && $day->count() > 0) {
            $types->push('page');
        }
        if (! empty($places) && $places->whereNotNull('latitude')->count() > 0) {
            $place = $places->whereNotNull('latitude')->random();
            $types->push('place');
        } else {
            $place = null;
        }

        $section = match ($types->random()) {
            'page' => View::make('public.day-in-the-life.banner.page', [
                'date' => $date,
                'day' => $day,
            ]),
            'people' => View::make('public.day-in-the-life.banner.people', [
                'date' => $date,
                'people' => $people,
            ]),
            'place' => View::make('public.day-in-the-life.banner.place', [
                'date' => $date,
                'place' => $place,
            ]),
        };

        //dd($people, $places, $topics);

        return view('public.day-in-the-life.banner.container', [
            'date' => $date,
            'section' => $section,
        ]);
    }
}
