<?php

namespace App\Http\Controllers;

use App\Models\Update;
use Illuminate\Http\Request;

class UpdateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('public.updates.index', [
            'updates' => Update::query()
                                ->where('enabled', 1)
                                ->where('publish_at', '<', now()->toDateTimeString())
                                ->orderBy('publish_at', 'DESC')
                                ->paginate(10),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Update  $update
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Update $update)
    {
        return view('public.updates.show', [
            'update' => $update,
        ]);
    }
}
