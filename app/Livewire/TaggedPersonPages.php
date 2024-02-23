<?php

namespace App\Livewire;

use App\Models\Page;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Lazy;
use Livewire\Component;
use Livewire\WithPagination;

#[Lazy]
class TaggedPersonPages extends Component
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
            ->select([
                'id',
                'item_id',
                'type_id',
                'uuid',
                'name',
                'full_name',
                'ftp_id',
                'ftp_link',
                'first_date',
                'transcript',
                'order',
                'parent_item_id',
                'created_at',
                'updated_at',
            ])
            ->with([
                'parent',
                'parent.type',
                'media',
            ])
            ->where(function ($query) use ($enabled) {
                $query->whereHas('parent', function (Builder $query) use ($enabled) {
                    $query->whereIn('items.enabled', $enabled);
                })
                    ->whereHas('subjects', function (Builder $query) {
                        $query->whereIn('id', array_merge([$this->subject->id], $this->subject->children->pluck('id')->all()));
                    });
            })
            ->paginate(10, pageName: 'page');

        return view('livewire.tagged-person-pages', [
            'pages' => $pages ?? collect(),
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
