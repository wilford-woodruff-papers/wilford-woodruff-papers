<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subject;
use App\Models\User;
use App\Notifications\PersonAssignmentNotification;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PeopleController extends Controller
{
    private $rules = [
        'name' => [
            'required',
            'max:191',
        ],
        'added_to_ftp_at' => [
            'max:191',
            'required_with:name',
        ],
        'first_name' => [
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
            'required_with:pid_identified_at',
        ],
        'pid_identified_at' => [
            'max:191',
            'required_with:pid',
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
        'reference' => [
            'max:191',
        ],
        'relationship' => [
            'max:191',
        ],
        'subcategory' => [
            'max:191',
        ],
    ];

    private $categories = [
        'Apostles',
        '1840 British Converts',
        'Business',
        'Family',
        'Host',
        'Scriptural Figures',
        '1835 Southern Converts',
        'Historical Figures',
        'Stationery Header',
        'Bishops in Letters',
        'United Brethren',
    ];

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $person = new Subject([
            'bio_completed_at' => null,
            'bio_approved_at' => null,
        ]);

        return view('admin.dashboard.people.edit', [
            'person' => $person,
            'researchers' => User::query()
                ->role(['researcher'])
                ->orderBy('name')
                    ->get(),
            'categories' => Category::query()
                ->whereIn('name', $this->categories)
                ->orderBy('name')
                ->get(),
            'subcategories' => [
                'British Convert',
                'Family',
                'Most Mentioned',
                'New England',
                'Other British',
                'Other Southern',
                'Southern Convert',
                'Utah Deaths',
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $person = new Subject();

        $this->rules['pid'] = [
            'nullable',
            'sometimes',
            'max:191',
            'required_with:pid_identified_at',
            'unique:subjects,pid',
        ];

        $validated = $request->validate($this->rules);

        $person->fill($validated);

        if (empty($person->unique_id)) {
            $uniqueId = Subject::query()
                ->whereHas('category', function ($query) {
                    $query->whereIn('categories.name', ['People']);
                })
                ->max('unique_id');
            $person->unique_id = $uniqueId + 1;
        }

        // TODO: Update the person's name

        $person->save();

        $person->category()->sync($request->get('categories'));

        $person->category()->syncWithoutDetaching(
            Category::query()
                ->where('name', 'People')
                ->first()
        );

        $request->session()->flash('success', 'Person created successfully!');

        if (! empty($person->researcher_id)
            && ($person->researcher_id != auth()->id())
        ) {
            $person->researcher->notify(new PersonAssignmentNotification($person));
        }

        if ($request->get('action') == 'new') {
            return redirect()->route('admin.dashboard.people.create');
        }

        return redirect()->route('admin.dashboard.people.edit', ['person' => $person]);
    }

    /**
     * Display the specified resource.
     *
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
     * @return \Illuminate\Http\Response
     */
    public function edit(Subject $person)
    {
        return view('admin.dashboard.people.edit', [
            'person' => $person,
            'researchers' => User::query()
                ->role(['Bio Editor', 'Bio Admin'])
                ->orderBy('name')
                ->get(),
            'categories' => Category::query()
                ->whereIn('name', $this->categories)
                ->orderBy('name')
                ->get(),
            'subcategories' => [
                'British Convert',
                'Family',
                'Most Mentioned',
                'New England',
                'Other British',
                'Other Southern',
                'Southern Convert',
                'Utah Deaths',
            ],
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subject $person)
    {
        $this->rules['pid'] = [
            'nullable',
            'sometimes',
            'max:191',
            'required_with:pid_identified_at',
            Rule::unique('subjects')->ignore($person->id),
        ];

        $validated = $request->validate($this->rules);

        $person->fill($validated);

        if (empty($person->unique_id)) {
            $uniqueId = Subject::query()
                ->whereHas('category', function ($query) {
                    $query->whereIn('categories.name', ['People']);
                })
                ->max('unique_id');
            $person->unique_id = $uniqueId + 1;
        }

        // TODO: Update the person's name
        $person->save();

        $person->category()->sync($request->get('categories'));

        $person->category()->syncWithoutDetaching(
            Category::query()
                ->where('name', 'People')
                ->first()
        );

        $request->session()->flash('success', 'Person updated successfully!');

        if (! empty($person->researcher_id)
            && $person->wasChanged('researcher_id')
            && ($person->researcher_id != auth()->id())
        ) {
            $person->researcher->notify(new PersonAssignmentNotification($person));
        }

        if ($request->get('action') == 'new') {
            return redirect()->route('admin.dashboard.people.create');
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subject $person)
    {
        abort_unless(auth()->user()->hasRole('Bio Admin'), 403);

        $person->delete();

        return redirect()->route('admin.people.index');
    }
}
