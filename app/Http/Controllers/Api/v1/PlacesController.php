<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

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

        $subjects = Subject::query();

        $categories = ['Places'];

        $subjects = $subjects->whereRelation('category', function (Builder $query) use ($categories) {
            $query->whereIn('name', $categories);
        });

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

        $subject = Subject::findOrFail($id);

        return response()->json($subject);
    }
}
