<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Page;
use App\Models\Subject;
use Illuminate\Http\Request;
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

        $content = str($content)
            ->addSubjectLinks()
            ->addScriptureLinks()
            ->removeQZCodes(false)
            ->replace('&amp;', '&');

        $previousDay = Page::previousDay($date->toDateString())
            ?->date
            ?->toDateString();
        $nextDay = Page::nextDay($date->toDateString())
            ?->date
            ?->toDateString();

        $people = $subjects->get('People');
        $places = $subjects->get('Places');
        $topics = $subjects->get('Index');

        $pages = Page::query()
            ->with([
                'parent',
            ])
            ->whereNotIn('id', $day->pluck('id')->all())
            ->whereHas('parent')
            ->whereRelation('dates', 'date', $date->toDateString())
            ->get();

        $events = Event::query()
            ->where('start_at', '<=', $date->toDateString())
            ->where('end_at', '>=', $date->toDateString())
            ->get();

        $quotes = $day->pluck('quotes')->flatten();

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
        ]);
    }
}
