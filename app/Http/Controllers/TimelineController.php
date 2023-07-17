<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\View\View;

class TimelineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $events = Event::query()
                            ->with([
                                'photos',
                                'media',
                                'pages.parent',
                                'places',
                            ])
                            ->orderBy('start_at', 'asc')
                            ->get()
                            ->map(function ($event) {
                                $event->text = str($event->text)->addScriptureLinks()->addSubjectLinks();

                                return $event;
                            });

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
