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
            ->whereNull('subject_id');

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

        return response()->json(
            $subjects->paginate(
                min($request->get('per_page', 100), 500)
            )
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

        return $subject;
    }
}
