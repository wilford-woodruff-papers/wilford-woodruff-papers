<?php

namespace App\Http\Controllers;

use App\Models\Subject;

class SubjectController extends Controller
{
    public function show(Subject $subject)
    {
        if (! empty($subject->redirect_to)) {
            return redirect()->route('subjects.show', ['subject' => Subject::findOrFail($subject->redirect_to)]);
        }

        if (request()->ajax()) {
            return [
                'name' => $subject->name,
                'slug' => $subject->slug,
                'bio' => $subject->bio,
            ];
        }

        $subject->load([
            'parent',
            'category',
            'children' => function ($query) {
                $query->when(auth()->guest() || (auth()->check() && ! auth()->user()->hasAnyRole(['Super Admin'])), fn ($query) => $query->where('hide_on_index', 0))
                    ->where('tagged_count', '>', 0);
            },
        ]);
        //->loadCount(['pages']);

        return view('public.subjects.show', [
            'subject' => $subject,
            'linkify' => new \Misd\Linkify\Linkify(['callback' => function ($url, $caption, $bool) {
                return '<a href="'.$url.'" class="text-secondary" target="_blank">'.$caption.'</a>';
            }]),
        ]);
    }
}
