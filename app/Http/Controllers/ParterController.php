<?php

namespace App\Http\Controllers;

use App\Models\PartnerCategory;
use Illuminate\View\View;

class ParterController extends Controller
{
    /**
     * Display a listing of the resource.
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
