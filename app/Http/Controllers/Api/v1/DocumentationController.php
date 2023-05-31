<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;

class DocumentationController extends Controller
{
    public function __invoke()
    {
        return view('api.v1.documentation');
    }
}
