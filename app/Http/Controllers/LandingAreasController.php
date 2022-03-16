<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingAreasController extends Controller
{
    public function search(Request $request)
    {
        return view('public.landing-areas.search');
    }

    public function ponder(Request $request)
    {
        return view('public.landing-areas.ponder');
    }

    public function serve(Request $request)
    {
        return view('public.landing-areas.serve');
    }

    public function testify(Request $request)
    {
        return view('public.landing-areas.testify');
    }
}
