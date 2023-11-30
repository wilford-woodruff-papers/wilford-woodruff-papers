<?php

namespace App\Livewire;

use App\Models\Page;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class Location extends Component
{
    public Subject $subject;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function mount(int|string $model)
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
        return view('livewire.location', [
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
            'linkify' => new \Misd\Linkify\Linkify(['callback' => function ($url, $caption, $bool) {
                return '<a href="'.$url.'" class="text-secondary" target="_blank">'.$caption.'</a>';
            }]),
        ]);
    }
}
