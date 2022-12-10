<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\Team;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function mission(Request $request)
    {
        return view('public.about.mission');
    }

    public function meetTheTeam(Request $request)
    {
        return view('public.about.meet-the-team', [
            'teams' => Team::query()
                                ->with('boardmembers')
                                ->ordered()
                                ->get(),
        ]);
    }

    public function editorialMethod(Request $request)
    {
        return view('public.about.editorial-method');
    }

    public function faqs(Request $request)
    {
        return view('public.about.frequently-asked-questions', [
            'faqs' => Faq::orderBy('order_column', 'ASC')->get(),
        ]);
    }

    public function contact(Request $request)
    {
        return view('public.contact-us');
    }
}
