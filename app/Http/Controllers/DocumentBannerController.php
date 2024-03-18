<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class DocumentBannerController extends Controller
{
    public function __invoke(Request $request, Item $item)
    {
        $item->load([
            'firstPageWithText',
        ]);

        $section = View::make('livewire.document-dashboard.banner.page', [
            'item' => $item,
        ]);

        //dd($people, $places, $topics);

        return view('livewire.document-dashboard.banner.container', [
            'item' => $item,
            'section' => $section,
        ]);
    }
}
