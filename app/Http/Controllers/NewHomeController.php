<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class NewHomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): View
    {
        return view('new-home', [
            //            'article' => Press::where('type', 'Article')->latest()->first(),
        ]);
    }
}
