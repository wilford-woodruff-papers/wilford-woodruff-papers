<?php

namespace App\Http\Controllers;

use App\Models\Date;
use App\Models\Item;
use App\Models\Page;
use App\Models\Type;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
                        ->orderBy('decade', 'ASC')
                        ->groupBy('decade');
        if ($request->has('type') && ($request->get('type') == Type::firstWhere('name', 'Letters')->id)) {
            $decades = $decades->where('type_id', $request->get('type'))
                                ->orderBy('decade')
                               ->get();
        }

        $years = DB::table('items')
                        ->select('year', DB::raw('count(*) as total'))
                        ->whereEnabled(1)
                        ->whereNotNull('year')
                        ->orderBy('year', 'ASC')
                        ->groupBy('year');
        if ($request->has('decade')) {
            $years = $years->where('type_id', $request->get('type'))
                               ->where('decade', $request->get('decade'))
                                ->orderBy('year')
                               ->get();
        }

        $items = Item::whereNull('item_id')
                        ->with('type')
                        ->whereEnabled(1);

        if ($request->has('type')) {
            $items = $items->where('type_id', $request->get('type'));
        }

        if ($request->has('decade')) {
            $items = $items->where('decade', $request->get('decade'));
        }

        if ($request->has('sort')) {
            $sort = explode(':', $request->get('sort'));
            $direction = ($sort[1] == 'asc' ? 'ASC' : 'DESC');
            switch ($sort[0]) {
                case 'title':
                    $items = $items->orderBy('name', $direction);
                    break;
                case 'added':
                    $items = $items->orderBy('added_to_collection_at', $direction);
                    break;
                default:
                    $items = $items->orderBy('sort_date', $direction);
            }
        } else {
            $items = $items->orderBy('added_to_collection_at', 'DESC');
        }

        return view('public.documents.index', [
            'types' => Type::whereNull('type_id')
                                ->withCount(['items' => function (Builder $query) {
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

        if (! empty($year)) {
            $months = Date::select(DB::raw('Distinct(MONTH(date)) as month'))
                        ->whereYear('date', $year)
                        ->orderBy('month', 'ASC')
                        ->get();
        }

        if (! empty($year) && ! empty($month)) {
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
                ->withCount(['items' => function (Builder $query) {
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        $pages = Page::with(['dates', 'subjects', 'parent'])
                        ->withCount('quotes')
                        ->where('parent_item_id', $item->id)
                        ->ordered();

        $item->setRelation('item', $item);
        $item->setRelation('pages', $pages);

        return view('public.documents.show', [
            'item' => $item,
            'pages' => $pages->paginate(20),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function transcript(Item $item)
    {
        $pages = Page::query()
                        ->where('parent_item_id', $item->id)
                        ->ordered()
                        ->get();

        $item->setRelation('pages', $pages);

        return view('public.documents.full-transcript', [
            'item' => $item,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        //
    }
}
