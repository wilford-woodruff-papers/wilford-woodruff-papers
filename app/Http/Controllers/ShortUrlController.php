<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\RedirectResponse;

class ShortUrlController extends Controller
{
    public function item($hashid): RedirectResponse
    {
        $item = \App\Models\Item::findByHashidOrFail($hashid);

        return redirect()->route('documents.show', [
            'item' => $item,
        ]);
    }

    public function page($hashid): RedirectResponse
    {
        $page = Page::findByHashidOrFail($hashid);

        return redirect()->route('pages.show', [
            'item' => $page->item,
            'page' => $page,
        ]);
    }
}
