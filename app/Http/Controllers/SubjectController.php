<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function show(Subject $subject)
    {

        return view('public.subjects.show', [
            'subject' => $subject,
        ]);
    }
}
