<?php

namespace App\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class Subject extends Component
{
    public $parents;

    public $query = null;

    public $new;

    public $showModal = false;

    public \App\Models\Subject $subject;

    protected $rules = [
        'subject.name' => 'required|min:2|max:255',
        'subject.hide_on_index' => 'boolean',
        'subject.subject_id' => 'integer',
    ];

    public function mount()
    {
        $this->parents = collect([]);
    }

    public function render()
    {
        if (! empty($this->query)) {
            $this->parents = \App\Models\Subject::query()
                ->where('id', '!=', $this->subject->id)
                ->where('name', 'LIKE', '%'.$this->query.'%')
                ->whereHas('category', function (Builder $query) {
                    $query->where('name', 'Index');
                })
                ->get();
        } else {
            $this->parents = collect([]);
        }

        return view('livewire.subject');
    }

    public function addChildren()
    {
        $category = \App\Models\Category::query()
            ->where('name', 'Index')
            ->first();
        $new = str($this->new)->explode(',')->map(function ($item) {
            return trim($item);
        })->each(function ($item) use ($category) {
            $subject = \App\Models\Subject::query()
                ->updateOrCreate([
                    'name' => $item,
                ], [
                    'subject_id' => $this->subject->id,
                ]);
            $category->subjects()->syncWithoutDetaching($subject->id);
        });
        $this->new = null;
        $this->subject->refresh();
        $this->dispatch('reloadTopics');
    }

    public function updatingSubject($value, $field)
    {
        if ($field == 'subject_id') {
            $this->showModal = false;
            $this->dispatch('reloadTopics');
            if (empty($value)) {
                $logMessage = auth()->user()->name.' updated removed parent of '.$this->subject->name;
            } else {
                $logMessage = auth()->user()->name.' updated parent of '.$this->subject->name.' to '.\App\Models\Subject::find($value)->name;
            }
            activity('activity')
                ->on($this->subject)
                ->event('parent updated')
                ->log($logMessage);
        }
        if ($field == 'hide_on_index') {
            activity('activity')
                ->on($this->subject)
                ->event('visibility updated')
                ->log(auth()->user()->name.' updated visibility of '.$this->subject->name.' to '.($value == 0 ? 'visible' : 'hidden'));
        }
        if ($field == 'name') {
            activity('activity')
                ->on($this->subject)
                ->event('name updated')
                ->log(auth()->user()->name.' updated name of '.$this->subject->name.' to '.$value);
        }

        $this->subject->{$field} = $value;
        $this->subject->save();
    }
}
