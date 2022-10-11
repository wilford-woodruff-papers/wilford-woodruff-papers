<?php

namespace App\Http\Livewire;

use App\Models\Subject;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class Topics extends Component
{
    public $letter = null;

    public $search = null;

    protected $queryString = ['letter' => ['except' => 'A'], 'search'];

    protected $listeners = ['reloadTopics' => 'refresh'];

    public function mount()
    {
        if (empty($this->search) && empty($this->letter)) {
            $this->letter = 'A';
        }
    }

    public function refresh()
    {
        $this->render();
    }

    public function render()
    {
        $topics = Subject::query()
                            ->with(['children' => function ($query) {
                                //$query->whereHas('pages');
                                $query->where('tagged_count', '>', 0)
                                    ->orWhere('text_count', '>', 0);
                            }])
                            ->whereEnabled(1)
                            ->when(empty($this->search), fn ($query, $search) => $query->whereNull('subject_id'))
                            ->when(auth()->guest() || (auth()->check() && ! auth()->user()->hasAnyRole(['Super Admin'])), fn ($query) => $query->where('hide_on_index', 0))
                            ->whereHas('category', function (Builder $query) {
                                $query->where('name', 'Index');
                            })
                            ->when($this->letter, fn ($query, $letter) => $query->where('name', 'LIKE', $letter.'%'))
                            ->when($this->search, function ($query, $search) {
                                $names = str($search)->explode(' ');
                                foreach ($names as $name) {
                                    $query = $query->where('name', 'LIKE', '%'.str($name)->trim(',')->toString().'%');
                                }
                            })
                            ->where(function ($query) {
                                $query->where('tagged_count', '>', 0)
                                    ->orWhere('text_count', '>', 0);
                            })
                            /*->where(function (Builder $query) {
                                $query->whereHas('pages')
                                    ->orWhereHas('children.pages')
                                    ->orWhereHas('quotes'); // This doesn't filter to only those with quotes that have been approved
                            })*/
                            ->orderBy('name', 'ASC')
                            ->get();

        return view('livewire.topics', [
            'topics' => $topics,
        ])
            ->layout('layouts.guest');
    }

    public function submit()
    {
    }

    public function updatedSearch()
    {
        $this->letter = null;
    }

    public function updatedLetter()
    {
        $this->search = null;
    }
}
