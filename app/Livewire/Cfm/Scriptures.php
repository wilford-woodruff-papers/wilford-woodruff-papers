<?php

namespace App\Livewire\Cfm;

use App\Models\ComeFollowMe;
use App\Models\Page;
use Livewire\Attributes\Lazy;
use Livewire\Component;

#[Lazy]
class Scriptures extends Component
{
    public ComeFollowMe $lesson;

    public bool $show = false;

    public function render()
    {
        $this->lesson->loadMissing([
            'chapters.book',
        ]);

        $pages = Page::query()
            ->with([
                'parent',
                'volumes.books.chapters',
            ])
            ->whereRelation('volumes', function ($query) {
                $query->where(function ($query) {
                    foreach ($this->lesson->chapters as $chapter) {
                        $query = $query
                            ->orWhere(function ($query) use ($chapter) {
                                $query->where('book', $chapter->book->name)
                                    ->where('chapter', $chapter->number);
                            });
                    }

                    return $query;
                });

                return $query;
            })
            ->get();

        foreach ($this->lesson->chapters as $chapter) {
            if ($pages->filter(function ($page) use ($chapter) {
                return $page->volumes
                    ->where('pivot.chapter', $chapter->number)
                    ->where('pivot.book', $chapter->book->name)
                    ->count() > 0;
            })
                ->count() > 0) {
                $this->show = true;
                break;
            }
        }

        return view('livewire.cfm.scriptures', [
            'pages' => $pages,
        ]);
    }
}
