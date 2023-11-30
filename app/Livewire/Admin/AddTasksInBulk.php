<?php

namespace App\Livewire\Admin;

use LivewireUI\Modal\ModalComponent;

class AddTasksInBulk extends ModalComponent
{
    public function render()
    {
        return view('livewire.admin.add-tasks-in-bulk');
    }
}
