<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

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

        $subjects = Subject::query();

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
