<?php

namespace App\Http\Controllers;

class AIDownloadController extends Controller
{
    public function __invoke()
    {
        return redirect()->route('content-page.show', ['contentPage' => 'wilford-woodruff-immersive-learning-experience']);
    }
}
