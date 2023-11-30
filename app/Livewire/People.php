<?php

namespace App\Livewire;

use App\Models\Subject;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class People extends Component
{
    public $category = 'All';

    public $letter = null;

    public $search = null;

    public $selectCategories = [
        'All',
        'Family',
        'Apostles',
        '1840 British Converts',
        'United Brethren',
        '1835 Southern Converts',
        'Eminent Men and Women',
        'Scriptural Figures',
    ];

    protected $queryString = [
        'category' => ['except' => 'All'],
        'letter' => ['except' => 'A'],
        'search',
    ];

    public function mount()
    {
        if (empty($this->search) && empty($this->letter)) {
            $this->letter = 'A';
        }
    }

    public function render()
    {
        $people = Subject::query()
            ->when($this->category == 'All', fn ($query, $category) => $query->whereHas('category', function (Builder $query) {
                $query->where('name', 'People');
            }))
            ->when($this->category != 'All', fn ($query, $category) => $query->whereHas('category', function (Builder $query) {
                $query->where('name', $this->category);
            }))
            ->when($this->letter && $this->category == 'All', fn ($query, $letter) => $query->where('index', $this->letter))
            ->when($this->search, function ($query, $search) {
                $names = str($search)->explode(' ');
                foreach ($names as $name) {
                    $query = $query->where('name', 'LIKE', '%'.str($name)->trim(',')->toString().'%');
                }
            });

        if ($this->category !== 'Eminent Men and Women') {
            $people = $people
                ->whereEnabled(1)
                ->where(function ($query) {
                    $query->where('tagged_count', '>', 0)
                        ->orWhere('text_count', '>', 0);
                });
        }

        //->whereHas('pages')
        $people = $people->orderBy('last_name', 'ASC')
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

    public function updatedCategory($value)
    {
        if ($value == 'All') {
            $this->letter = 'A';
        } else {
            $this->letter = null;
        }
    }
}
