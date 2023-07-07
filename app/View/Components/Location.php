<?php

namespace App\View\Components;

use App\Models\Page;
use App\Models\Quote;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\Component;

class Location extends Component
{
    public Subject $subject;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($model)
    {
        $this->subject = Subject::findOrFail($model);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $this->subject->load([
            'parent',
            'children' => function ($query) {
                $query->when(auth()->guest() || (auth()->check() && ! auth()->user()->hasAnyRole(['Super Admin'])), fn ($query) => $query->where('hide_on_index', 0))
                    ->whereHas('pages')
                    ->withCount(['pages']);
            },
        ]);

        return view('components.location', [
            'subject' => $this->subject,
            'pages' => Page::query()
                ->with([
                    'item',
                    'item.type',
                    'parent.type',
                    'media',
                    'dates',
                    'people',
                    'places',
                ])
                ->where(function ($query) {
                    $query->whereHas('item', function (Builder $query) {
                        $query->where('items.enabled', true);
                    })
                        ->whereHas('subjects', function (Builder $query) {
                            $query->whereIn('id', array_merge([$this->subject->id], $this->subject->children->pluck('id')->all()));
                        })
                        /*->orWhereHas('quotes.topics', function (Builder $query) use ($subject) {
                            $query->where('subjects.id', $subject->id)
                                    ->whereHas('quotes.actions');
                        })*/;
                })
                ->paginate(10),
            'quotes' => Quote::query()
                ->with([
                    'page',
                    'page.parent.type',
                    'page.dates',
                    'page.people',
                    'page.places',
                    'page.item',
                    'page.media',
                ])
                ->whereNotNull('text')
                ->whereNull('continued_from_previous_page')
                ->whereHas('actions')
                ->where(function ($query) {
                    $query->whereHas('page.parent', function (Builder $query) {
                        $query->where('items.enabled', true);
                    })
                        ->whereHas('topics', function (Builder $query) {
                            $query->whereIn('subjects.id', array_merge([$this->subject->id], $this->subject->children->pluck('id')->all()));
                        })/*
                    ->orWhereHas('topics', function (Builder $query) use ($subject) {
//                        $query->where('subjects.id', $subject->id);
                    })*/;
                })
                ->paginate(10, ['*'], 'quotes_page'),
            'linkify' => new \Misd\Linkify\Linkify(['callback' => function ($url, $caption, $bool) {
                return '<a href="'.$url.'" class="text-secondary" target="_blank">'.$caption.'</a>';
            }]),
        ]);
    }
}
