<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\Update;
use Illuminate\Http\Request;

class UpdateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
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
     */
    public function show(Request $request, Update $update): View
    {
        return view('public.updates.show', [
            'update' => $update,
        ]);
    }
}
