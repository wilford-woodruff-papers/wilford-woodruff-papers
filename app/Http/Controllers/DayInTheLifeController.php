<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Page;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Date;

class DayInTheLifeController extends Controller
{
    public function __invoke(Request $request, $date = null)
    {
        $date = ! is_null($date)
            ? Date::createFromFormat('Y-m-d', $date)
            : Date::createFromFormat('Y-m-d', '1807-03-01');

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

        if ($day->count() < 1) {
            return redirect()->route('day-in-the-life', [
                'date' => Page::nextDay($date->toDateString())
                    ?->date
                    ?->toDateString(),
            ]);
        }

        $content = $day
            ->map(function ($entry) use ($date) {
                return str($entry->transcript)
                    ->extractContentOnDate($date);
            })
            ->join("\n");

        $subjects = Subject::extractFromText($content);

        $content = str($content)
            ->addSubjectLinks()
            ->addScriptureLinks()
            ->removeQZCodes(false)
            ->replace('&amp;', '&')
            ->replace('<p>. ', '<p>')
            ->trim();

        $previousDay = Page::previousDay($date->toDateString())
            ?->date
            ?->toDateString();
        $nextDay = Page::nextDay($date->toDateString())
            ?->date
            ?->toDateString();

        $people = $subjects->get('People')
            ?->sortBy('name');
        $places = $subjects->get('Places')
            ?->sortBy('name');
        $topics = $subjects->get('Index')
            ?->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE);

        $pages = Page::query()
            ->with([
                'parent',
                'media',
            ])
            ->whereNotIn('id', $day->pluck('id')->all())
            ->whereHas('parent')
            ->whereRelation('dates', 'date', $date->toDateString())
            ->get();
        $eventRange = clone $date;
        //dd($date->toDateString(), $eventRange->subMonths(2)->toDateString(), $eventRange->addMonths(4)->toDateString());
        $events = Event::query()
            ->where(function ($query) use ($date) {
                $query->where('start_at', '=', $date->toDateString());
            })
            ->orWhere(function ($query) use ($eventRange) {
                $query->where('start_at', '>=', $eventRange->subMonths(2)->toDateString())
                    ->where('start_at', '<=', $eventRange->addMonths(4)->toDateString());
            })
            ->orderBy('start_at')
            ->get();

        $quotes = $day->pluck('quotes')->flatten();

        $allDates = Cache::remember('all-dates', 3600, function () {
            return \App\Models\Date::query()
                ->select('date')
                ->where('dateable_type', Page::class)
                ->whereHasMorph('dateable', Page::class, function ($query) {
                    $query->whereRelation('parent', 'type_id', 5);
                })
                ->distinct()
                ->orderBy('date', 'asc')
                ->toBase()
                ->get();
        });

        ray($allDates);

        return view('public.day-in-the-life.index', [
            'date' => $date,
            'day' => $day,
            'content' => $content,
            'previousDay' => $previousDay,
            'nextDay' => $nextDay,
            'people' => $people,
            'places' => $places,
            'topics' => $topics,
            'pages' => $pages,
            'events' => $events,
            'quotes' => $quotes,
            'allDates' => $allDates,
        ]);
    }
}
