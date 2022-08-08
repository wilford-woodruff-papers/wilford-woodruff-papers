<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class SitemapController extends Controller
{
    public function __invoke(Request $request)
    {
        return response()->view('sitemap', [
            'documents' => Item::query()
                            ->select('uuid', 'updated_at')
                            ->where('enabled', 1)
                            ->get(),
        ])->withHeaders([
            'Content-Type' => 'application/xml'
        ]);
    }
}
