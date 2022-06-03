<?php

namespace App\Http\Livewire\Admin;

use App\Models\TargetPublishDate;
use Livewire\Component;

class Progress extends Component
{
    public $targetsDates;

    public function render()
    {
        $this->targetsDates = TargetPublishDate::query()
            ->with('items.actions.type')
            ->orderBy('publish_at', 'ASC')
            ->limit(4)
            ->get();

        return view('livewire.admin.progress');
    }
}
