<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlacesController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $place = new Subject();

        return view('admin.dashboard.places.edit', [
            'place' => $place,
            'researchers' => User::query()
                ->role(['researcher'])
                ->orderBy('name')
                    ->get(),
            'countries' => DB::table('subjects')
                ->select('country')
                ->distinct()
                ->whereNotNull('country')
                ->orderBy('country', 'asc')
                ->pluck('country', 'country')
                ->toArray(),
            'states' => DB::table('subjects')
                ->select('state_province')
                ->distinct()
                ->whereNotNull('state_province')
                ->orderBy('state_province', 'asc')
                ->pluck('state_province', 'state_province')
                ->toArray(),
            'counties' => DB::table('subjects')
                ->select('county')
                ->distinct()
                ->whereNotNull('county')
                ->orderBy('county', 'asc')
                ->pluck('county', 'county')
                ->toArray(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $place = new Subject();

        $validated = $request->validate([
            'country' => [
                'max:191',
            ],
            'state_province' => [
                'max:191',
            ],
            'county' => [
                'max:191',
            ],
            'city' => [
                'max:191',
            ],
            'specific_place' => [
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

        $place->fill($validated);

        // Update the place's name
        $place->name = collect([
            $place->specific_place,
            $place->city,
            $place->county,
            $place->state_province,
            $place->country,
        ])
            ->filter()
            ->implode(', ');

        $place->save();

        $place->category()->syncWithoutDetaching(
            Category::query()
                ->where('name', 'Places')
                ->first()
        );

        $request->session()->flash('success', 'place created successfully!');

        return redirect()->route('admin.dashboard.places.edit', ['place' => $place]);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Subject $place)
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
    public function edit(Subject $place)
    {
        return view('admin.dashboard.places.edit', [
            'place' => $place,
            'researchers' => User::query()
                ->role(['researcher'])
                ->orderBy('name')
                ->get(),
            'countries' => DB::table('subjects')
                ->select('country')
                ->distinct()
                ->whereNotNull('country')
                ->orderBy('country', 'asc')
                ->pluck('country', 'country')
                ->toArray(),
            'states' => DB::table('subjects')
                ->select('state_province')
                ->distinct()
                ->whereNotNull('state_province')
                ->orderBy('state_province', 'asc')
                ->pluck('state_province', 'state_province')
                ->toArray(),
            'counties' => DB::table('subjects')
                ->select('county')
                ->distinct()
                ->whereNotNull('county')
                ->orderBy('county', 'asc')
                ->pluck('county', 'county')
                ->toArray(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subject $place)
    {
        $validated = $request->validate([
            'country' => [
                'max:191',
            ],
            'state_province' => [
                'max:191',
            ],
            'county' => [
                'max:191',
            ],
            'city' => [
                'max:191',
            ],
            'specific_place' => [
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

        $place->fill($validated);

        if (empty($place->unique_id)) {
            $uniqueId = Subject::query()
                ->whereHas('category', function ($query) {
                    $query->whereIn('categories.name', ['Places']);
                })
                ->max('unique_id');
            $place->unique_id = $uniqueId + 1;
        }

        // Update the place's name
        $place->name = collect([
            $place->specific_place,
            $place->city,
            $place->county,
            $place->state_province,
            $place->country,
        ])
            ->filter()
            ->implode(', ');

        $place->save();

        $place->category()->syncWithoutDetaching(
            Category::query()
                ->where('name', 'Places')
                ->first()
        );

        $request->session()->flash('success', 'place updated successfully!');

        return redirect()->route('admin.dashboard.places.edit', ['place' => $place->slug]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subject $place)
    {
        //
    }
}
