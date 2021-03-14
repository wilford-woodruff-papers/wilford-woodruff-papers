<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GetInvolvedController extends Controller
{
    public function volunteer(Request $request)
    {
        return view('public.get-involved.volunteer');
    }

    public function contribute(Request $request)
    {
        return view('public.get-involved.contribute');
    }
}
