<?php

namespace App\Http\Livewire;

use App\Models\Subject;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class People extends Component
{
    public $letter = null;

    public $search = null;

    protected $queryString = ['letter' => ['except' => 'A'], 'search'];

    public function mount()
    {
        if(empty($this->search) && empty($this->letter)){
            $this->letter = 'A';
        }
    }

    public function render()
    {
        $people = Subject::query()
                            ->whereEnabled(1)
                            ->whereHas('category', function (Builder $query) {
                                $query->where('name', 'People');
                            })
                            ->when($this->letter, fn($query, $letter) => $query->where('last_name', 'LIKE', $letter.'%'))
                            ->when($this->search, fn($query, $search) => $query->where('name', 'LIKE', '%'.$search.'%'))
                            ->whereHas('pages')
                            ->orderBy('last_name', 'ASC')
                            ->orderBy('name', 'ASC')
                            ->get();

        return view('livewire.people', [
            'people' => $people,
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
