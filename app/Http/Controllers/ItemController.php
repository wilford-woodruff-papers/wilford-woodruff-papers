<?php

namespace App\Http\Controllers;

use App\Models\Date;
use App\Models\Decade;
use App\Models\Item;
use App\Models\Page;
use App\Models\Type;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\MediaLibrary\MediaCollections\Exceptions\UnreachableUrl;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $decades = DB::table('items')
                        ->select('decade', DB::raw('count(*) as total'))
                        ->whereEnabled(1)
                        ->whereNotNull('decade')
                        ->groupBy('decade');
        if($request->has('type') && ($request->get('type') == Type::firstWhere('name', 'Letters')->id)){
            $decades = $decades->where('type_id', $request->get('type'))
                               ->get();
        }

        $years = DB::table('items')
                        ->select('year', DB::raw('count(*) as total'))
                        ->whereEnabled(1)
                        ->whereNotNull('year')
                        ->groupBy('year');
        if($request->has('decade')){
            $years = $years->where('type_id', $request->get('type'))
                               ->where('decade', $request->get('decade'))
                               ->get();
        }
        $items = Item::whereNull('item_id')
                        ->with('type')
                        ->whereEnabled(1);

        if($request->has('type')){
            $items = $items->where('type_id', $request->get('type'));
        }

        if($request->has('decade')){
            $items = $items->where('decade', $request->get('decade'));
        }

        if($request->has('sort')){
            $sort = explode(":", $request->get('sort'));
            $direction = ($sort[1] == 'desc'? 'DESC' : 'ASC');
            switch($sort[0]){
                case 'title':
                    $items = $items->orderBy('name', $direction);
                    break;
                case 'added':
                    $items = $items->orderBy('added_to_collection_at', $direction);
                    break;
                default:
                    $items = $items->orderBy('sort_date', $direction);

            }
        }else{
            $items = $items->orderBy('sort_date', 'ASC');
        }

        return view('public.documents.index', [
            'types' => Type::whereNull('type_id')
                                ->withCount(['items' => function(Builder $query){
                                    $query->where('enabled', 1);
                                }])
                                ->orderBy('name', 'ASC')
                                ->get(),
            'items' => $items->paginate(25),
            'decades' => $decades,
            'years' => $years,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dates(Request $request, $year = null, $month = null)
    {
        $months = null;
        $pages = null;
        $years = Date::select(DB::raw('Distinct(YEAR(date)) as year'))
                        ->orderBy('year', 'ASC')
                        ->get();

        if(! empty($year)){
            $months = Date::select(DB::raw('Distinct(MONTH(date)) as month'))
                        ->whereYear('date', $year)
                        ->orderBy('month', 'ASC')
                        ->get();

        }

        if(! empty($year) && ! empty($month)){
            /*$items = Item::whereNull('item_id')
                            ->whereHas('pages', function (Builder $query) use ($year, $month) {
                                $query->whereHas('dates', function (Builder $query) use ($year, $month) {
                                    $query->whereYear('date', $year)
                                        ->whereMonth('date', $month);
                                });
                            })
                            ->with('type')
                            ->whereEnabled(1)
                            ->get();*/
            $pages = Page::whereHas('dates', function (Builder $query) use ($year, $month) {
                            $query->whereYear('date', $year)
                                ->whereMonth('date', $month);
                            })
                            ->get();
        }

        return view('public.documents.dates', [
            'types' => Type::whereNull('type_id')
                ->withCount(['items' => function(Builder $query){
                    $query->where('enabled', 1);
                }])->get(),
            'years' => $years,
            'months' => $months,
            'pages' => $pages,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        $pages = Page::with(['dates', 'subjects', 'item', 'parent'])
                        ->where('parent_item_id', $item->id)
                        ->ordered();

        $item->setRelation('pages', $pages);

        return view('public.documents.show', [
            'item' => $item,
            'pages' => $pages->paginate(20),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        //
    }
}
