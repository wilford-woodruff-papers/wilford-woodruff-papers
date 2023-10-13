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
        $eventRegistration->event_name = 'Friday 13th Giveaway';

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

        return back()->with('success', 'Thank you for entering the Wilford Woodruff Papers Project Giveaway! Look for an email announcing the winners in the coming week.');
    }

    public function live()
    {
        return view('event-registration.live');
    }
}
