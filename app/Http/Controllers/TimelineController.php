<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\Event;
use Illuminate\Support\Facades\DB;

class TimelineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $events = Event::query()
                            ->with('photos', 'pages.parent')
                            ->orderBy('start_year')
                            ->orderBy(DB::raw('LENGTH(start_month)'))
                            ->orderBy('start_month')
                            ->orderBy(DB::raw('LENGTH(start_day)'))
                            ->orderBy('start_day')
                            ->get();

        return view('public.timeline', [
            'events' => $events,
            'timeline_json' => [
                'title' => [
                    'text' => [
                        //'headline' => 'TIMELINE OF WILFORD WOODRUFF\'S LIFE IN THE CONTEXT OF US AND CHURCH HISTORY',
                        'text' => '',
                    ],
                    'background' => [
                        'color' => '#b4a488',
                    ],
                    'media' => [
                        'url' => 'https://www.josephsmithpapers.org/bc-jsp/content/jsp/images/content/library/images/A1-Page-644d-Woodruff-Wilford-PH-6821-it-1.jpg',
                        'thumbnail' => 'https://www.josephsmithpapers.org/bc-jsp/content/jsp/images/content/library/images/A1-Page-644d-Woodruff-Wilford-PH-6821-it-1.jpg',
                    ],
                ],
                'events' => $events->toArray(),
            ],
        ]);
    }
}
