<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DonationController extends Controller
{
    public function index(Request $request)
    {
        return view('public.donate.index');
    }

    public function online(Request $request)
    {
        return view('public.donate.online');
    }

    public function questions(Request $request)
    {
        return view('public.donate.questions');
    }
}
