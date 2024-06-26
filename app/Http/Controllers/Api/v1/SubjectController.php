<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public $typesMap = [
        'Places' => ['Places'],
        'People' => ['People'],
        'Topics' => ['Index'],
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
                'created_at',
                'updated_at',
                'total_usage_count',
                'bio',
                'life_years',
                'years',
            ])
            ->with([
                'category',
            ])
            ->where(function (Builder $query) {
                $query->whereNull('subject_id')
                    ->orWhere('subject_id', 0);
            });

        if ($request->has('types')) {
            $types = [];
            foreach ($request->get('types') as $type) {
                abort_if(! isset($this->typesMap[$type]), 422, 'Invalid type: '.$type);
                if (isset($this->typesMap[$type])) {
                    $types = array_merge($types, $this->typesMap[$type]);
                }
            }

            $subjects = $subjects->whereRelation('category', function (Builder $query) use ($types) {
                $query->whereIn('name', $types);
            });
        }

        if ($request->has('q')) {
            $subjects = $subjects->where('name', 'like', '%'.$request->get('q').'%');
        }

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
            ->with([
                'category',
            ])
            ->where('id', $id)
            ->select([
                'id',
                'slug',
                'name',
                'created_at',
                'updated_at',
                'total_usage_count',
            ])
            ->firstOrFail();

        $subject->setAppends([]);

        return $subject;
    }
}
