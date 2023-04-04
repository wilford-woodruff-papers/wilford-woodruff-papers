<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Press;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function __invoke(Request $request): Response
    {
        return response()->view('sitemap', [
            'documents' => Item::query()
                            ->select('id', 'item_id', 'uuid', 'updated_at')
                            ->where('enabled', 1)
                            ->whereNull('item_id')
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
            'Content-Type' => 'application/xml',
        ]);
    }
}
