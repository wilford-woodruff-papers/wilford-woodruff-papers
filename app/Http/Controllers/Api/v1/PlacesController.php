<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PlacesController extends Controller
{
    public $categoriesMap = [

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
                'slug',
                'name',
                'address',
                'country',
                'state_province',
                'county',
                'city',
                'specific_place',
                'modern_location',
                'latitude',
                'longitude',
                'created_at',
                'updated_at',
                'total_usage_count',
                'reference',
                'visited',
                'mentioned',
            ]);

        $categories = ['Places'];

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
                'slug',
                'name',
                'address',
                'country',
                'state_province',
                'county',
                'city',
                'specific_place',
                'modern_location',
                'latitude',
                'longitude',
                'created_at',
                'updated_at',
                'total_usage_count',
                'reference',
                'visited',
                'mentioned',
            ])
            ->firstOrFail();

        $subject->setAppends([]);

        return response()->json($subject);
    }

    public function export(Request $request)
    {
        abort_unless($request->user()->tokenCan('read'), 401);

        return Storage::disk('exports')
            ->download('places-export.csv', now('America/Denver')->toDateString().'-places-export.csv');
    }
}
