<?php

namespace App\Livewire\DocumentDashboard;

use App\Models\Page;
use App\Models\Subject;
use Illuminate\Support\Collection;
use Livewire\Component;

class Topics extends Component
{
    public int $itemId;

    public Collection $topics;

    public string $column = 'name';

    public string $direction = 'asc';

    public function render()
    {
        $this->getTopics();

        return view('livewire.document-dashboard.sections.topics');
    }

    public function getTopics()
    {
        $topics = Subject::query()
            ->with([
                'category',
            ])
            ->index()
            ->whereNull('subject_id')
            ->whereHas('pages', function ($query) {
                $query->whereIn(
                    'id',
                    Page::query()
                        ->select('id')
                        ->where('parent_item_id', $this->itemId)
                        ->pluck('id')
                        ->toArray()
                );
            });

        if ($this->column === 'name') {
            $topics = $topics
                ->orderBy('name', $this->direction, SORT_NATURAL | SORT_FLAG_CASE);
        } else {
            $people = $topics->orderBy('tagged_count', $this->direction);
        }

        $this->topics = $topics->get();
    }

    public function toggleSort($column)
    {
        if ($this->column !== $column) {
            $this->direction = 'asc';
            $this->column = $column;
        } else {
            $this->direction = ($this->direction === 'asc') ? 'desc' : 'asc';
        }
    }
}
