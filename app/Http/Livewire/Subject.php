<?php

namespace App\Http\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class Subject extends Component
{
    public $parents;

    public $query = null;

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

    public function updatingSubject($value, $field)
    {
        if ($field == 'subject_id') {
            $this->showModal = false;
            $this->emit('reloadTopics');
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
