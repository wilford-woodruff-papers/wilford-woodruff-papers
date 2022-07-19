<?php

namespace App\Http\Livewire\Admin;

use App\Models\TargetPublishDate;
use App\Models\Type;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class Progress extends Component
{
    public $targetsDates;

    public function render()
    {
        $userRoles = auth()->user()->roles;

        $this->targetsDates = TargetPublishDate::query()
            ->with('items.actions.type')
            ->orderBy('publish_at', 'ASC')
            ->limit(4)
            ->get();

        return view('livewire.admin.progress');
    }
}
