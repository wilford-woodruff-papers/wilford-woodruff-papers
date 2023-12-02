<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AboutController extends Controller
{
    public function mission(Request $request): View
    {
        return view('public.about.mission');
    }

    public function meetTheTeam(Request $request): View
    {
        return view('public.about.meet-the-team', [
            'teams' => Team::query()
                ->with('boardmembers')
                ->ordered()
                ->get(),
        ]);
    }

    public function editorialMethod(Request $request): View
    {
        return view('public.about.editorial-method');
    }

    public function faqs(Request $request): View
    {
        return view('public.about.frequently-asked-questions', [
            'faqs' => Faq::orderBy('order_column', 'ASC')->get(),
        ]);
    }

    public function contact(Request $request): View
    {
        return view('public.contact-us');
    }
}
