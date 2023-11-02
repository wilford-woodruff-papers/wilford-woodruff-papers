<?php

namespace App\Http\Controllers;

use App\Models\Day;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

class DayInTheLifeController extends Controller
{
    public function __invoke(Request $request, $date = null)
    {
        $date = ! is_null($date)
            ? Date::createFromFormat('Y-m-d', $date)
            : Date::createFromFormat('Y-m-d', '1807-03-01');

        $day = Day::query()
            ->where('date', $date->toDateString())
            ->orderBy('order', 'asc')
            ->get();

        return view('public.day-in-the-life.index', [
            'date' => $date,
            'day' => $day,
        ]);
    }
}
