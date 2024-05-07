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

        return view('livewire.cfm.scriptures', [
            'pages' => $pages,
        ]);
    }
}
