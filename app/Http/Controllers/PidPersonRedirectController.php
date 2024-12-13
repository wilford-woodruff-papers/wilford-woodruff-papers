<?php

namespace App\Http\Controllers;

use App\Models\Subject;

class PidPersonRedirectController extends Controller
{
    public function __invoke($pid)
    {
        $person = Subject::where('pid', $pid)->first();

        if (empty($person)) {
            return redirect()->route('people');
        }

        return redirect()->route('subjects.show', ['subject' => $person]);
    }
}
