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
        if (! empty($subject->redirect_to)) {
            return redirect()->route('subjects.show', ['subject' => Subject::findOrFail($subject->redirect_to)]);
        }

        if (request()->ajax()) {
            return $subject;
        }

        $subject->load(['parent', 'children' => function($query){
            $query->whereHas('pages');
        }]);

        return view('public.subjects.show', [
            'subject' => $subject,
            'pages' => Page::whereHas('subjects', function (Builder $query) use ($subject) {
                $query->where('id', $subject->id);
            })->paginate(10),
        ]);
    }
}
