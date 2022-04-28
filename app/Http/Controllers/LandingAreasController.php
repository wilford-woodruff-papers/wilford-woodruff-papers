<?php

namespace App\Http\Controllers;

use App\Models\Press;
use Illuminate\Http\Request;

class LandingAreasController extends Controller
{
    public function search(Request $request)
    {
        return view('public.landing-areas.search');
    }

    public function ponder(Request $request, $press = null)
    {
        return view('public.landing-areas.ponder', [
            'press' => $press,
        ]);
    }

    public function press(Request $request, Press $press)
    {
        return view('public.landing-areas.media.show', [
            'press' => $press,
        ]);
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
