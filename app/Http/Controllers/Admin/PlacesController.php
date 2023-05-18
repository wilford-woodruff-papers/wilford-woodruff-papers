<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlacesController extends Controller
{
    private $rules = [
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
        'years' => [
            'max:191',
        ],
        'place_confirmed_at' => [
            'max:191',
        ],
        'visited' => [
            'nullable',
        ],
        'mentioned' => [
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
        'reference' => [
            'nullable',
        ],
        'notes' => [
            'nullable',
        ],
        'log_link' => [
            'max:191',
        ],
    ];

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $place = new Subject([
            'bio_completed_at' => null,
            'bio_approved_at' => null,
        ]);

        return view('admin.dashboard.places.edit', [
            'place' => $place,
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

        $validated = $request->validate($this->rules);

        $place->fill($validated);

        // Update the place's name
        $place->name = collect([
            $place->specific_place,
            $place->city,
            $place->county,
            $place->state_province,
            $place->includeCountryInName($place->state_province, $place->country),
        ])
            ->filter()
            ->implode(', ');

        $place->save();

        if (! empty($request->get('subject_id'))) {
            $place->subject_id = $request->get('subject_id');
        }

        $place->category()->syncWithoutDetaching(
            Category::query()
                ->where('name', 'Places')
                ->first()
        );

        $request->session()->flash('success', 'place created successfully!');

        if ($request->get('action') == 'new') {
            return redirect()->route('admin.dashboard.places.create');
        }

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
        $validated = $request->validate($this->rules);

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
            $place->includeCountryInName($place->state_province, $place->country),
        ])
            ->filter()
            ->implode(', ');

        if (! empty($request->get('subject_id'))) {
            $place->subject_id = $request->get('subject_id');
        }

        $place->save();

        $place->category()->syncWithoutDetaching(
            Category::query()
                ->where('name', 'Places')
                ->first()
        );

        $request->session()->flash('success', 'place updated successfully!');

        if ($request->get('action') == 'new') {
            return redirect()->route('admin.dashboard.places.create');
        }

        return redirect()->route('admin.dashboard.places.edit', ['place' => $place]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subject $place)
    {
        $place->delete();

        return redirect()->route('admin.places.index');
    }
}
