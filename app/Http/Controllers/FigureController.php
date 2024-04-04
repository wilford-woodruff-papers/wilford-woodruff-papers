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
                ->orderBy('tracking_number', 'asc')
                ->get(),
        ]);
    }
}
