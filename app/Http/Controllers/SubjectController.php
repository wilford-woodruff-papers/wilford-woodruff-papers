<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Builder;

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

        $subject->load(['parent', 'children' => function ($query) {
            $query->when(auth()->guest() || (auth()->check() && ! auth()->user()->hasAnyRole(['Super Admin'])), fn ($query) => $query->where('hide_on_index', 0))
                ->whereHas('pages')
                ->withCount(['pages']);
        }])
            ->loadCount(['pages']);

        return view('public.subjects.show', [
            'subject' => $subject,
            'pages' => Page::query()
                            ->where(function ($query) use ($subject) {
                                $query->whereHas('item', function (Builder $query) {
                                    $query->where('items.enabled', true);
                                })
                                ->whereHas('subjects', function (Builder $query) use ($subject) {
                                    $query->whereIn('id', array_merge([$subject->id], $subject->children->pluck('id')->all()));
                                })
                                ->orWhereHas('quotes.topics', function (Builder $query) use ($subject) {
                                    $query->where('subjects.id', $subject->id)
                                            ->whereHas('quotes.actions');
                                });
                            })
                            ->paginate(10),
        ]);
    }
}
