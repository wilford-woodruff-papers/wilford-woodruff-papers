<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;

class PeopleController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $person = new Subject();

        return view('admin.dashboard.people.edit', [
            'person' => $person,
            'researchers' => User::query()
                ->role(['researcher'])
                ->orderBy('name')
                    ->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $person = new Subject();

        $validated = $request->validate([
            'first_name' => [
                'required',
                'max:191',
            ],
            'middle_name' => [
                'max:191',
            ],
            'last_name' => [
                'max:191',
            ],
            'suffix' => [
                'max:191',
            ],
            'alternate_names' => [
                'max:191',
            ],
            'maiden_name' => [
                'max:191',
            ],
            'birth_date' => [
                'max:191',
            ],
            'baptism_date' => [
                'max:191',
            ],
            'death_date' => [
                'max:191',
            ],
            'life_years' => [
                'max:191',
            ],
            'pid' => [
                'max:191',
            ],
            'pid_identified_at' => [
                'max:191',
            ],
            'researcher_id' => [
                'nullable',
            ],
            'bio' => [
                'nullable',
            ],
            'bio_completed_at' => [
                'max:191',
            ],
            'bio_approved_at' => [
                'max:191',
            ],
            'footnotes' => [
                'nullable',
            ],
            'notes' => [
                'nullable',
            ],
            'log_link' => [
                'max:191',
            ],
        ]);

        $person->fill($validated);

        // TODO: Update the person's name

        $person->save();

        $person->category()->sync($request->get('categories'));

        $person->category()->syncWithoutDetaching(
            Category::query()
                ->where('name', 'People')
                ->first()
        );

        $request->session()->flash('success', 'Person created successfully!');

        return redirect()->route('admin.dashboard.people.edit', ['person' => $person]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subject  $person
     * @return \Illuminate\Http\Response
     */
    public function show(Subject $person)
    {
        return view('admin.dashboard.people.edit', [
            'person' => $person,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subject  $person
     * @return \Illuminate\Http\Response
     */
    public function edit(Subject $person)
    {
        return view('admin.dashboard.people.edit', [
            'person' => $person,
            'researchers' => User::query()
                ->role(['researcher'])
                ->orderBy('name')
                ->get(),
            'categories' => Category::query()
                ->whereIn('name', [
                    'Apostles',
                    '1840 British Converts',
                    'Business',
                    'Family',
                    'Host',
                    'Scriptural Figures',
                    '1835 Southern Converts',
                ])
                ->orderBy('name')
                ->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subject  $person
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subject $person)
    {
        $validated = $request->validate([
            'first_name' => [
                'required',
                'max:191',
            ],
            'middle_name' => [
                'max:191',
            ],
            'last_name' => [
                'max:191',
            ],
            'suffix' => [
                'max:191',
            ],
            'alternate_names' => [
                'max:191',
            ],
            'maiden_name' => [
                'max:191',
            ],
            'birth_date' => [
                'max:191',
            ],
            'baptism_date' => [
                'max:191',
            ],
            'death_date' => [
                'max:191',
            ],
            'life_years' => [
                'max:191',
            ],
            'pid' => [
                'max:191',
            ],
            'pid_identified_at' => [
                'max:191',
            ],
            'researcher_id' => [
                'nullable',
            ],
            'bio' => [
                'nullable',
            ],
            'bio_completed_at' => [
                'max:191',
            ],
            'bio_approved_at' => [
                'max:191',
            ],
            'footnotes' => [
                'nullable',
            ],
            'notes' => [
                'nullable',
            ],
            'log_link' => [
                'max:191',
            ],
        ]);

        $person->fill($validated);

        // TODO: Update the person's name
        $person->save();

        $person->category()->sync($request->get('categories'));

        $person->category()->syncWithoutDetaching(
            Category::query()
                ->where('name', 'People')
                ->first()
        );

        $request->session()->flash('success', 'Person updated successfully!');

        return redirect()->route('admin.dashboard.people.edit', ['person' => $person->slug]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subject  $person
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subject $person)
    {
        //
    }
}
