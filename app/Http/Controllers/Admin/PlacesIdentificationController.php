<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PlaceIdentification;
use App\Models\User;
use App\Notifications\NewCorrectionNeeded;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class PlacesIdentificationController extends Controller
{
    private $rules = [
        'editorial_assistant' => [
            'max:191',
        ],
        'title' => [
            'max:191',
        ],
        'first_middle_name' => [
            'max:191',
        ],
        'last_name' => [
            'max:191',
        ],
        'other' => [
            'max:191',
        ],
        'link_to_ftp' => [
            'max:2048',
            'required',
        ],
        'guesses' => [
            'nullable',
        ],
        'location' => [
            'required',
            'max:191',
        ],
        'completed_at' => [
            'max:191',
        ],
        'notes' => [
            'nullable',
        ],
        'fs_id' => [
            'max:191',
        ],
        'approximate_birth_date' => [
            'max:191',
        ],
        'approximate_death_date' => [
            'max:191',
        ],
        'nauvoo_database' => [
            'nullable',
        ],
        'pioneer_database' => [
            'nullable',
        ],
        'missionary_database' => [
            'max:191',
        ],
        'boston_index' => [
            'max:191',
        ],
        'st_louis_index' => [
            'nullable',
        ],
        'british_mission' => [
            'nullable',
        ],
        'eighteen_forty_census' => [
            'max:191',
        ],
        'eighteen_fifty_census' => [
            'max:191',
        ],
        'eighteen_sixty_census' => [
            'max:191',
        ],
        'other_census' => [
            'max:191',
        ],
        'other_records' => [
            'max:191',
        ],
        'skip_tagging' => [
            'nullable',
        ],
        'correction_needed' => [
            'nullable',
            'boolean',
        ],
    ];

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $place = new PlaceIdentification();

        return view('admin.dashboard.places.identification', [
            'place' => $place,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $place = new PlaceIdentification();

        $validated = $request->validate($this->rules);

        $place->fill($validated);

        // TODO: Update the place's name

        $place->save();

        $request->session()->flash('success', 'Place created successfully!');

        if ($place->correction_needed) {
            $users = User::query()->role('Bio Admin')->get();
            Notification::send($users, new NewCorrectionNeeded($place));
        }

        return redirect()->route('admin.dashboard.identification.places.edit', ['identification' => $place]);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(PlaceIdentification $place)
    {
        return view('admin.dashboard.places.edit', [
            'place' => $place,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(PlaceIdentification $place)
    {
        return view('admin.dashboard.places.identification', [
            'place' => $place,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PlaceIdentification $place)
    {
        $validated = $request->validate($this->rules);

        $place->fill($validated);

        if ($place->isDirty('correction_needed') && $place->correction_needed) {
            $users = User::query()->role('Bio Admin')->get();
            Notification::send($users, new NewCorrectionNeeded($place));
        }

        $place->save();

        $request->session()->flash('success', 'Place updated successfully!');

        return redirect()->route('admin.dashboard.identification.places.edit', ['identification' => $place]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(PlaceIdentification $place)
    {
        $place->delete();

        return redirect()->route('admin.dashboard.identification.places.index');
    }
}
