<?php

namespace App\Http\Controllers;

use App\Models\Parter;

class ParterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('public.partners.index', [
            'partnerCategories' => Parter::query()
                                    ->get()
                                    ->groupBy('category'),
        ]);
    }
}
