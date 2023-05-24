<?php

namespace App\Http\Livewire\Admin\Subjects\People;

use App\Models\Date;
use App\Models\Subject;
use Livewire\Component;
use Livewire\WithPagination;

class Search extends Component
{
    use WithPagination;

    public $readyToLoad = false;

    public $search = null;

    public $dates = [
        'start' => null,
        'end' => null,
    ];

    protected $queryString = [
        'dates' => ['except' => ''],
        'search',
    ];

    public function mount()
    {
        $this->dates['start'] = request('dates.start') ?? Date::query()->min('date');
        $this->dates['end'] = request('dates.end') ?? Date::query()->max('date');
    }

    public function render()
    {
        if ($this->readyToLoad) {
            $people = Subject::query()
                ->with(['pages' => function ($query) {
                    $query->whereHas('taggedDates', function ($query) {
                        $query->where('date', '>=', $this->dates['start'])
                            ->where('date', '<', $this->dates['end']);
                    });
                }])
                ->whereHas('category', function ($query) {
                    $query->whereIn('categories.name', ['People']);
                })
                ->whereHas('pages', function ($query) {
                    $query->whereHas('taggedDates', function ($query) {
                        $query->where('date', '>=', $this->dates['start'])
                            ->where('date', '<', $this->dates['end']);
                    });
                })
                ->paginate(50);
        }

        return view('livewire.admin.people.search', [
            'people' => $people ?? [],
        ])
            ->layout('layouts.admin');
    }

    public function load()
    {
        $this->readyToLoad = true;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingDates()
    {
        $this->resetPage();
    }

    public function updatingPage()
    {
        $this->emit('scroll-to-top');
    }
}
