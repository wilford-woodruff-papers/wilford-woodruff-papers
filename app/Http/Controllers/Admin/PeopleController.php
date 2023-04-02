<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PeopleController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'name' => 'required|max:255',
        ]);

        $person->fill($validated);

        $person->save();

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
            'name' => [
                'required',
                'max:255',
                Rule::unique('subjects', 'slug')->ignore($person->id, 'id'),
            ],
        ]);

        $person->fill($validated);

        $person->save();

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
