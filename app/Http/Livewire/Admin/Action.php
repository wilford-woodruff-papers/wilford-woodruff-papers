<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Action extends Component
{
    public \App\Models\Action $action;

    public $assignee;

    public $finisher;

    public $users;

    public function mount()
    {
        $this->users = Cache::remember('users', 60, function () {
            return User::role('Editor')->orderBy('name')->pluck('name', 'id')->all();
        });
    }

    public function render()
    {
        return view('livewire.admin.action');
    }

    public function updatedAssignee($value)
    {
        $this->action->assigned_to = $value;
        $this->action->assigned_at = now();
        $this->action->save();
        $this->action = $this->action->fresh(['assignee', 'finisher']);
    }

    public function updatedFinisher($value)
    {
        $this->action->completed_by = $value;
        $this->action->completed_at = now();
        $this->action->save();
        $this->action = $this->action->fresh(['assignee', 'finisher']);
    }
}
