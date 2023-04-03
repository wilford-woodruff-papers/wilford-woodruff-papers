<?php

namespace App\Http\Controllers;

use App\Models\Press;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return view('home', [
            'article' => Press::where('type', 'Article')->latest()->first(),
        ]);
    }
}
