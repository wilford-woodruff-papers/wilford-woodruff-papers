<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\PartnerCategory;

class ParterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        return view('public.partners.index', [
            'partnerCategories' => PartnerCategory::query()
                                    ->with('partners')
                                    ->ordered()
                                    ->get(),
        ]);
    }
}
