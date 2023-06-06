<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;

class DocumentationController extends Controller
{
    public function __invoke()
    {
        if (auth()->user()->tokens()->count() < 1) {
            return redirect()->route('api-tokens.index');
        }

        return view('api.v1.documentation');
    }
}
