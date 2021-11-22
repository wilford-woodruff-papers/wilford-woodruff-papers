<?php

namespace App\Http\Controllers;

use App\Models\JobOpportunity;
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

    public function workWithUs(Request $request)
    {
        return view('public.get-involved.work-with-us', [
            'opportunities' => JobOpportunity::where('title', '!=', 'Internship Opportunities')->where('start_at', '<', now())->where('end_at', '>', now())->get(),
        ]);
    }

    public function jobOpportunity(Request $request, JobOpportunity $opportunity)
    {
        return view('public.get-involved.job-opportunity', [
            'opportunity' => $opportunity,
        ]);
    }
}
