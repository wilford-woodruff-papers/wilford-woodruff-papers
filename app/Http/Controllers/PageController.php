<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\Item;
use App\Models\Page;
use Illuminate\Database\Eloquent\Builder;

class PageController extends Controller
{
    public function show(Item $item, Page $page): View
    {
        $item = $item->parent();
        $page->load(['dates', 'topics', 'subjects' => function ($query) {
            $query->whereHas('category', function (Builder $query) {
                $query->whereIn('categories.name', ['People', 'Places']);
            });
        }]);

        return view('public.pages.show', [
            'item' => $item,
            'page' => $page,
            'pages' => Page::where('parent_item_id', $item->id)
                        ->ordered()->get(),
        ]);
    }
}
