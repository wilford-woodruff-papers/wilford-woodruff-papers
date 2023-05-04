<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PeopleIdentification;
use App\Models\User;
use App\Notifications\NewCorrectionNeeded;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class PeopleIdentificationController extends Controller
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
        $person = new PeopleIdentification();

        return view('admin.dashboard.people.identification', [
            'person' => $person,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $person = new PeopleIdentification();

        $validated = $request->validate($this->rules);

        $person->fill($validated);

        // TODO: Update the person's name

        $person->save();

        $request->session()->flash('success', 'Person created successfully!');

        if ($person->correction_needed) {
            $users = User::query()->role('Bio Admin')->get();
            Notification::send($users, new NewCorrectionNeeded($person));
        }

        return redirect()->route('admin.dashboard.identification.people.edit', ['identification' => $person]);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(PeopleIdentification $person)
    {
        return view('admin.dashboard.people.edit', [
            'identification' => $person,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(PeopleIdentification $person)
    {
        return view('admin.dashboard.people.identification', [
            'person' => $person,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PeopleIdentification $person)
    {
        $validated = $request->validate($this->rules);

        $person->fill($validated);

        if ($person->isDirty('correction_needed') && $person->correction_needed) {
            $users = User::query()->role('Bio Admin')->get();
            Notification::send($users, new NewCorrectionNeeded($person));
        }

        $person->save();

        $request->session()->flash('success', 'Person updated successfully!');

        return redirect()->route('admin.dashboard.identification.people.edit', ['identification' => $person]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(PeopleIdentification $person)
    {
        $person->delete();

        return redirect()->route('admin.dashboard.identification.people.index');
    }
}
