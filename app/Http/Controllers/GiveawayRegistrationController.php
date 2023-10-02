<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRegistrationRequest;
use App\Models\EventRegistration;
use App\Models\User;

class GiveawayRegistrationController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('event-registration.giveaway.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventRegistrationRequest $request)
    {
        $validated = $request->validated();

        $eventRegistration = EventRegistration::make($validated);
        $eventRegistration->event_name = 'St. George Giveaway';

        if ($request->has('fields')) {
            foreach ($request->get('fields') as $key => $value) {
                $attribute = str($key)->replace("'", '')->toString();
                $eventRegistration->extra_attributes->{$attribute} = clean($value);
            }
        }

        $eventRegistration->save();

        if (app()->environment(['production'])) {
            $user = User::firstWhere('email', 'lexie.bailey@wilfordwoodruffpapers.org');
            $user->notify(new \App\Notifications\NewEventRegistrationNotification($eventRegistration));
        }

        return back()->with('success', "Thank you for registering for the Private Reception preceding the Development of Temple Doctrine Fireside on <b>October 8th</b>! We'll send you a reminder email with the link to access the event a few days before the event.");
    }

    public function live()
    {
        return view('event-registration.live');
    }
}
