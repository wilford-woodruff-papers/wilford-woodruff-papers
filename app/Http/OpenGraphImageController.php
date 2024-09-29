<?php

namespace App\Http;

use App\Http\Controllers\Controller;
use App\src\OgImageGenerator;
use Illuminate\Http\Request;

class OpenGraphImageController extends Controller
{
    public function __invoke(Request $request)
    {
        if (! app()->environment('local') && ! $request->hasValidSignature()) {
            abort(403);
        }

        $image = cache()->rememberForever('opengraph.image.'.$request->signature, function () use ($request) {
            return (new OgImageGenerator)->render(
                view('open-graph-image::template', $request->all())
                    ->render()
            );
        });

        return response($image)
            ->header('Content-Type', 'image/png');
    }
}
