<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\src\DocumentBannerImageGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class DocumentDashboardImageController extends Controller
{
    public function __invoke(Request $request, Item $item)
    {

        $image = cache()->rememberForever('document.'.$item->id.'.ogimage', function () use ($item) {
            $item->load([
                'firstPageWithText',
            ]);
            $section = View::make('livewire.document-dashboard.banner.page', [
                'item' => $item,
            ]);

            return (new DocumentBannerImageGenerator())->render(
                view('livewire.document-dashboard.banner.container')
                    ->with([
                        'item' => $item,
                        'section' => $section,
                    ])
                    ->render()
            );
        });

        return response($image)
            ->header('Content-Type', 'image/png');
    }
}
