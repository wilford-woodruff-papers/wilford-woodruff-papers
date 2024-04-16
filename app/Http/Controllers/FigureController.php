<?php

namespace App\Http\Controllers;

use App\Models\Figure;
use Illuminate\Http\Request;

class FigureController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return view('public.figures.index', [
            'figures' => Figure::query()
                ->get()
                ->sortBy('tracking_number', SORT_NATURAL | SORT_FLAG_CASE),
        ]);
    }
}
