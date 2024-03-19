<?php

namespace App\Livewire\Admin\ProgressMatrix;

use App\Models\Action;
use App\Models\ActionType;
use App\Models\Page;
use App\Models\Type;
use Livewire\Component;

class CompletionStatus extends Component
{
    public $readyToLoad = false;

    public $document_type;

    public $action_type;

    public $total = 0;

    public $status = '';

    public function render()
    {
        if (! in_array($this->document_type, ['Journals', 'Journal Sections'])
            && $this->action_type == '4LV'
        ) {
            $this->status = 'N/A';
        }
        if ($this->readyToLoad) {
            $needed = Action::query()
                ->whereHasMorph('actionable', [Page::class],
                    function ($query) {
                        $query->whereHas('parent', function ($query) {
                            $query->whereHas('type', function ($query) {
                                $query->whereIn('id', Type::whereIn('name', $this->document_type)->pluck('id')->toArray());
                            });
                        });
                    })
                ->where('action_type_id', ActionType::firstWhere('name', $this->action_type)->id)
                ->where('actionable_type', Page::class)
                ->whereNotNull('completed_at')
                ->whereNotNull('completed_by')
                ->count();

            if ($this->total - $needed <= 0) {
                $this->status = 'Completed';
            }

        }

        return view('livewire.admin.progress-matrix.completion-status');
    }

    public function load()
    {
        $this->readyToLoad = true;
    }
}
