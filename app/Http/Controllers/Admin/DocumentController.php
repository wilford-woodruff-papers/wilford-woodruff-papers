<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Page;
use App\Models\Type;
use App\Models\Value;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('admin.dashboard.documents.index');
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
        $item = new Item();

        $validated = $request->validate([
            'name' => 'required|max:255',
            'type_id' => 'required',
            'pcf_unique_id_prefix' => 'sometimes|required|string',
            'manual_page_count' => 'integer',
        ]);

        $item->fill($validated);

        if ($request->get('section_count') > 0) {
            $item->parental_type = \App\Models\Set::class;
        } else {
            $item->parental_type = \App\Models\Document::class;
        }

        $item->save();

        $properties = collect($request->all())->filter(function ($value, $key) {
            return str($key)->startsWith('property_');
        });

        foreach ($properties as $key => $value) {
            if (str($value)->trim()->isNotEmpty()) {
                Value::updateOrCreate([
                    'item_id' => $item->id,
                    'property_id' => str($key)->afterLast('_')->toString(),
                ], [
                    'value' => $value,
                ]);
            } elseif (str($key)->afterLast('_')->isNotEmpty()) {
                Value::query()
                    ->where('item_id', $item->id)
                    ->where('property_id', str($key)->afterLast('_')->toString())
                    ->delete();
            }
        }

        $type = Type::query()
            ->with(['subType'])
            ->firstWhere('id', $request->get('type_id'));

        if ($request->get('section_count') > 0) {
            for ($i = 1; $i <= $request->integer('section_count'); $i++) {
                $section = new Item;
                $section->parental_type = \App\Models\Document::class;
                $section->name = $item->name.' Section '.$i;
                $section->item_id = $item->id;
                $section->type_id = $type->subType?->id;
                $section->pcf_unique_id_prefix = $item->pcf_unique_id_prefix;
                //$section->pcf_unique_id = $item->pcf_unique_id;
                $section->save();
            }
        }

        $request->session()->flash('success', 'Document created successfully!');

        return redirect()->route('admin.dashboard.document.edit', ['item' => $item->uuid]);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        /*$item->load(['actions' => function($query){
            return $query->whereNotNull('actions.completed_at');
        }], ['actions.assignee' => function($query){
            return $query->whereNotNull('actions.completed_at');
        }], ['actions.finisher' => function($query){
            return $query->whereNotNull('actions.completed_at');
        }], 'activities');*/

        $item->load([
            'actions.type',
            'actions.type.roles',
            'actions.assignee',
            'actions.finisher',
            'activities',
            'pages.actions.type',
        ]);

        return view('admin.dashboard.documents.show', [
            'item' => $item,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Page  $page
     */
    public function edit(Item $item): View
    {
        $item->load([
            'values',
        ]);

        $item->loadCount([
            'pages',
        ]);

        return view('admin.dashboard.documents.edit', [
            'item' => $item,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        $item->fill($request->only([
            'name',
            'manual_page_count',
        ]));

        $item->save();

        $properties = collect($request->all())->filter(function ($value, $key) {
            return str($key)->startsWith('property_');
        });

        foreach ($properties as $key => $value) {
            if (str($value)->trim()->isNotEmpty()) {
                Value::updateOrCreate([
                    'item_id' => $item->id,
                    'property_id' => str($key)->afterLast('_')->toString(),
                ], [
                    'value' => $value,
                ]);
            } elseif (str($key)->afterLast('_')->isNotEmpty()) {
                Value::query()
                    ->where('item_id', $item->id)
                    ->where('property_id', str($key)->afterLast('_')->toString())
                    ->delete();
            }
        }

        $request->session()->flash('success', 'Document updated successfully!');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page)
    {
        //
    }
}
