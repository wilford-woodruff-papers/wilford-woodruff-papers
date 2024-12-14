<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PeopleController extends Controller
{
    public $categoriesMap = [
        'Apostles' => 'Apostles',
        '1840 British Converts' => '1840 British Converts',
        'Family' => 'Family',
        'Scriptural Figures' => 'Scriptural Figures',
        '1835 Southern Converts' => '1835 Southern Converts',
        'Historical Figures' => 'Historical Figures',
        'Bishops in Letters' => 'Bishops in Letters',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        abort_unless($request->ajax() || $request->user()->tokenCan('read'), 401);

        $subjects = Subject::query()
            ->select([
                'id',
                DB::raw('pid as family_search_id'),
                'slug',
                'name',
                'gender',
                'first_name',
                'middle_name',
                'last_name',
                'suffix',
                'alternate_names',
                'maiden_name',
                'bio',
                'footnotes',
                'created_at',
                'updated_at',
                'total_usage_count',
                'reference',
                'relationship',
                'birth_date',
                'baptism_date',
                'death_date',
                'life_years',
            ]);

        $categories = [];

        if ($request->has('categories')) {
            foreach ($request->get('categories') as $category) {
                abort_if(! isset($this->categoriesMap[$category]), 422, 'Invalid category: '.$category);
            }
            $categories = array_merge($categories, $request->get('categories'));
        } else {
            $categories = ['People'];
        }

        $subjects = $subjects->whereRelation('category', function (Builder $query) use ($categories) {
            $query->whereIn('name', $categories);
        });

        $subjects = $subjects->paginate(
            min($request->get('per_page', 100), 500)
        );

        $subjects = $subjects->setCollection(collect($subjects->items())->map(function ($subject) {
            if (auth()->check() && auth()->user()->hasAnyRole(['Super Admin'])) {
                return array_merge($subject->attributesToArray(), $subject->relationsToArray());
            } else {
                return [
                    'name' => $subject->name,
                    'types' => $subject->category,
                    'links' => [
                        'frontend_url' => $subject->slug ? route('subjects.show', ['subject' => $subject->slug]) : '',
                        'api_url' => $subject->id ? route('api.subjects.show', ['id' => $subject->id]) : '',
                    ],
                ];
            }
        }));

        return response()->json(
            $subjects
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        abort_unless($request->ajax() || $request->user()->tokenCan('read'), 401);

        $subject = Subject::query()
            ->where('id', $id)
            ->select([
                'id',
                DB::raw('pid as family_search_id'),
                'slug',
                'name',
                'gender',
                'first_name',
                'middle_name',
                'last_name',
                'suffix',
                'alternate_names',
                'maiden_name',
                'bio',
                'footnotes',
                'created_at',
                'updated_at',
                'total_usage_count',
                'reference',
                'relationship',
                'birth_date',
                'baptism_date',
                'death_date',
                'life_years',
            ])
            ->firstOrFail();

        return response()->json($subject);
    }

    public function export(Request $request)
    {
        abort_unless($request->user()->tokenCan('read'), 401);

        return Storage::disk('exports')
            ->download('people-export.csv', now('America/Denver')->toDateString().'-people-export.csv');
    }
}
