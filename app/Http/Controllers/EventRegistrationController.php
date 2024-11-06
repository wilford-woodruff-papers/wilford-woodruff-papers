<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRegistrationRequest;
use App\Models\EventRegistration;
use App\Models\User;

class EventRegistrationController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('event-registration.private-reception.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventRegistrationRequest $request)
    {
        $validated = $request->validated();

        $eventRegistration = EventRegistration::make($validated);
        $eventRegistration->event_name = 'Evening of Appreciation';

        foreach ($request->get('fields') as $key => $value) {
            $attribute = str($key)->replace("'", '')->toString();
            $eventRegistration->extra_attributes->{$attribute} = clean($value);
        }

        $eventRegistration->save();

        if (app()->environment(['production'])) {
            $user = User::firstWhere('email', 'lexie.bailey@wilfordwoodruffpapers.org');
            $user->notify(new \App\Notifications\NewEventRegistrationNotification($eventRegistration));
        }

        return back()->with('success', "Thank you for registering for the Wilford Woodruff Papers Evening of Appreciation with Elder Neil L. Andersen on <b>Feb 28th</b>! We'll send you a reminder email a few days before the event.");
    }

    public function live()
    {
        return view('event-registration.live');
    }
}
