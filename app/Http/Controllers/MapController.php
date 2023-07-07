<?php

namespace App\Http\Controllers;

class MapController extends Controller
{
    public function __invoke()
    {
        return view('livewire.map');
    }
}
