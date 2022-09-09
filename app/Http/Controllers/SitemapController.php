<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Press;
use App\Models\Subject;
use Illuminate\Http\Request;

class SitemapController extends Controller
{
    public function __invoke(Request $request)
    {
        return response()->view('sitemap', [
            'documents' => Item::query()
                            ->select('uuid', 'updated_at')
                            ->with('pages')
                            ->where('enabled', 1)
                            ->get(),
            'presses' => Press::query()
                                ->select('title', 'slug', 'updated_at')
                                ->orderBy('date', 'DESC')
                                ->get(),
            'subjects' => Subject::query()
                                ->select('name', 'slug', 'updated_at')
                                ->whereEnabled(1)
                                ->whereHas('pages')
                                ->get(),
        ])->withHeaders([
            'Content-Type' => 'application/xml'
        ]);
    }
}
