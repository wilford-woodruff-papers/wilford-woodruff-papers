<?php

namespace App\Livewire;

use App\Models\Page;
use App\Models\Quote;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Lazy;
use Livewire\Component;
use Livewire\WithPagination;

#[Lazy]
class TaggedPages extends Component
{
    use WithPagination;

    public \App\Models\Subject $subject;

    public function render()
    {
        if (auth()->check() && auth()->user()->hasAnyRole(['Editor', 'Researcher', 'Bio Admin', 'Bio Editor', 'Admin', 'Super Admin'])) {
            $enabled = [0, 1];
        } else {
            $enabled = [1];
        }

        $this
            ->subject
            ->loadMissing([
                'category',
                'children',
            ]);

        $pages = Page::query()
            ->with([
                'parent',
                'parent.type',
                'media',
            ])
            ->where(function ($query) use ($enabled) {
                $query->whereHas('item', function (Builder $query) use ($enabled) {
                    $query->whereIn('items.enabled', $enabled);
                })
                    ->whereHas('subjects', function (Builder $query) {
                        $query->whereIn('id', array_merge([$this->subject->id], $this->subject->children->pluck('id')->all()));
                    });
            })
            ->paginate(10, pageName: 'page');

        //if ($this->subject->category('name', 'Index')) {
        $quotes = Quote::query()
            ->with([
                'page',
                'page.parent.type',
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
                        $query->whereIn('subjects.id',
                            array_merge([$this->subject->id], $this->subject->children->pluck('id')->all())
                        );
                    });
            })
            ->paginate(10, pageName: 'quotes_page');
        //}

        return view('livewire.tagged-pages', [
            'pages' => $pages ?? collect(),
            'quotes' => $quotes ?? collect(),
        ]);
    }

    public function placeholder()
    {
        return <<<'HTML'
        <div class="flex z-20 justify-center items-center w-full h-128 bg-white opacity-50">
               <div class="animate-ping">
                   Loading...
               </div>
           </div>
        HTML;
    }
}
