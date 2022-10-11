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
            if (! empty(\App\Models\Subject::find($value)->subject_id) && empty(\App\Models\Subject::find($value)->parent?->subject_id)) {
                return;
            }
            $this->showModal = false;
            $this->emit('reloadTopics');
        }

        $this->subject->{$field} = $value;
        $this->subject->save();
    }
}
