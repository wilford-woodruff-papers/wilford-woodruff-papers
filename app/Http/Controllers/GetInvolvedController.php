<?php

namespace App\Http\Controllers;

use App\Models\JobOpportunity;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GetInvolvedController extends Controller
{
    public function index(Request $request): View
    {
        return view('public.get-involved.index');
    }

    public function volunteer(Request $request): View
    {
        return view('public.get-involved.volunteer');
    }

    public function contribute(Request $request): View
    {
        return view('public.get-involved.contribute');
    }

    public function workWithUs(Request $request): View
    {
        return view('public.get-involved.work-with-us', [
            'opportunities' => JobOpportunity::where('title', '!=', 'Internship Opportunities')->where('start_at', '<', now())->where('end_at', '>', now())->get(),
        ]);
    }

    public function jobOpportunity(Request $request, JobOpportunity $opportunity): View
    {
        return view('public.get-involved.job-opportunity', [
            'opportunity' => $opportunity,
        ]);
    }
}
