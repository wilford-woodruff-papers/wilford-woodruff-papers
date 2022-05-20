<?php

namespace App\Http\Livewire\Admin;

use App\Models\TargetPublishDate;
use Livewire\Component;

class TargetPublishDates extends Component
{
    public TargetPublishDate $targetDate;

    protected $rules = [
        'targetDate.publish_at' => 'required|date',
    ];

    public function mount()
    {
        $this->targetDate = new TargetPublishDate;
    }

    public function render()
    {
        return view('livewire.admin.target-publish-dates', [
            'dates' => TargetPublishDate::orderBy('publish_at', 'DESC')
                            ->get(),
        ])
            ->layout('layouts.admin');
    }

    public function editTargetDate($id){
        $this->targetDate = TargetPublishDate::firstOrNew(['id' => $id]);
    }

    public function saveTargetDate(){
        $this->validate();

        $this->targetDate->save();

        $this->targetDate = new TargetPublishDate;
    }

    public function deleteTargetDate($id){

        TargetPublishDate::destroy($id);
    }
}
