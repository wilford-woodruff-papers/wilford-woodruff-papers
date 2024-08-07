<?php

namespace App\Http\Controllers;

use App\Models\Update;
use Illuminate\Http\Request;
use Illuminate\View\View;

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
    public function show(Request $request, Update $update): View|\Illuminate\Http\RedirectResponse
    {
        if (in_array($update->type, ['Newsletter', 'Annual'])) {
            return redirect()->away($update->url);
        }

        return view('public.updates.show', [
            'update' => $update,
        ]);
    }
}
