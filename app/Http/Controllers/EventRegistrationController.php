<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRegistrationRequest;
use App\Models\EventRegistration;

class EventRegistrationController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('event-registration.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventRegistrationRequest $request)
    {
        $validated = $request->validated();

        $eventRegistration = EventRegistration::make($validated);

        foreach ($request->get('fields') as $key => $value) {
            $attribute = str($key)->replace("'", '')->toString();
            $eventRegistration->extra_attributes->{$attribute} = clean($value);
        }

        $eventRegistration->save();

        return back()->with('success', "Thank you for registering for the Ask Me Anything Mission President Leadership Panel on <b>June 25th</b>! We'll send you a reminder email with the link to access the event a few days before the event.");
    }

    public function live()
    {
        return view('event-registration.live');
    }
}
