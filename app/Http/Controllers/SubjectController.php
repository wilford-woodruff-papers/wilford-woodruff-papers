<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function show(Subject $subject)
    {
        if(request()->ajax()){
            return $subject;
        }

        return view('public.subjects.show', [
            'subject' => $subject,
            'pages' => Page::whereHas('subjects', function (Builder $query) use ($subject) {
                            $query->where('id', $subject->id);
                        })->paginate(10),
        ]);
    }
}
