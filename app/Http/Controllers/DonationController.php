<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class DonationController extends Controller
{
    public function index(Request $request): View
    {
        return view('public.donate.index');
    }

    public function online(Request $request): View
    {
        return view('public.donate.online');
    }

    public function questions(Request $request): View
    {
        return view('public.donate.questions');
    }
}
