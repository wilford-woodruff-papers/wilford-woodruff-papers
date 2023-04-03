<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\Press;
use Illuminate\Http\Request;

class LandingAreasController extends Controller
{
    public function search(Request $request): View
    {
        return view('public.landing-areas.search');
    }

    public function ponder(Request $request, $press = null): View
    {
        return view('public.landing-areas.ponder', [
            'press' => $press,
        ]);
    }

    public function press(Request $request, Press $press): View
    {
        return view('public.landing-areas.media.show', [
            'press' => $press,
        ]);
    }

    public function serve(Request $request): View
    {
        return view('public.landing-areas.serve');
    }

    public function testify(Request $request): View
    {
        return view('public.landing-areas.testify');
    }
}
