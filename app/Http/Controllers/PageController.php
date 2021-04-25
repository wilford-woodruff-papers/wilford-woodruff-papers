<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function show(Item $item, Page $page)
    {
        $item = $item->parent();
        $page->load('dates', 'subjects');

        return view('public.pages.show', [
            'item' => $item,
            'page' => $page,
            'pages' => Page::where('parent_item_id', $item->id)
                        ->ordered()->get(),
        ]);
    }
}
