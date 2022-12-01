<?php

namespace App\Http\Livewire\Admin\Documents;

use Livewire\Component;

class Task extends Component
{
    public $item;

    public $show = false;

    public function mount($item)
    {
        $this->item = $item;
    }

    public function render()
    {
        $this->item->loadMissing(
            'pending_actions',
            'pending_page_actions',
            'pending_page_actions.type',
        );
        $this->item->loadCount(
            'pending_page_actions',
        );
        if ($this->show) {
            $this->item->loadMissing(
                'page_actions',
                'page_actions.finisher',
                'page_actions.type',
                'pending_page_actions.actionable.completed_actions.type',
            );
        }

        return view('livewire.admin.documents.task');
    }
}
