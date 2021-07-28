<?php

namespace App\Http\Controllers;

use App\Models\Date;
use App\Models\Page;
use App\Models\Type;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $pages = new Page;
        $pages = $pages->with('item')
                        ->whereHas('item', function (Builder $query) {
                            $query->where('enabled', 1);
                        });

        if($request->has('q')){
            $pages = $pages->where(function($query) use ($request) {
                                $query->where('name', 'LIKE', '%'.$request->get('q').'%')
                                      ->orWhere('transcript', 'LIKE', '%'.$request->get('q').'%');
                            });
        }

        if($request->has('types')){
            $pages = $pages->whereIn('type_id', $request->get('types'));
        }

        if($request->get('use_min_date') == "true" && $request->has('min_date')){
            $pages = $pages->whereHas('dates', function (Builder $query) use ($request) {
                $query->where('date', '>=', $request->get('min_date'));
            });
        }

        if($request->get('use_max_date') == "true" && $request->has('max_date')){
            $pages = $pages->whereHas('dates', function (Builder $query) use ($request) {
                $query->where('date', '<=', $request->get('max_date'));
            });
        }

        return view('public.search', [
            'types' => Type::where('name', 'NOT LIKE', '%Sections%')->get(),
            'pages' => $pages->paginate(20),
            'dates' => [
                'min' => Date::where('dateable_type', Page::class)->orderBy('date', 'ASC')->first(),
                'max' => Date::where('dateable_type', Page::class)->orderBy('date', 'DESC')->first(),
            ],
        ]);
    }
}
