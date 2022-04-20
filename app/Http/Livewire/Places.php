<?php

namespace App\Http\Livewire;

use App\Models\Subject;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class Places extends Component
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
        $places = Subject::query()
                            ->whereEnabled(1)
                            ->whereHas('category', function (Builder $query) {
                                $query->where('name', 'Places');
                            })
                            ->when($this->letter, fn($query, $letter) => $query->where('name', 'LIKE', $letter.'%'))
                            ->when($this->search, fn($query, $search) => $query->where('name', 'LIKE', '%'.$search.'%'))
                            ->whereHas('pages')
                            ->orderBy('name', 'ASC')
                            ->get();

        return view('livewire.places', [
            'places' => $places,
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
