<?php

namespace App\Livewire\Admin\ProgressMatrix;

use App\Models\ActionType;
use App\Models\Goal;
use App\Models\Page;
use App\Models\Type;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class PastWork extends Component
{
    public $readyToLoad = false;

    public $document_type;

    public $action_type;

    public $dates;

    public $total = '';

    public $goal = '';

    public $percentage = '';

    public function render()
    {
        if ($this->readyToLoad) {
            $this->total = DB::table('actions')
                ->join('action_types', 'action_types.id', '=', 'actions.action_type_id')
                ->join('pages', 'pages.id', '=', 'actions.actionable_id')
                ->join('items', 'items.id', '=', 'pages.item_id')
                ->join('types', 'types.id', '=', 'items.type_id')
                ->where('actions.actionable_type', Page::class)
                ->whereIn('items.type_id', Type::whereIn('name', $this->document_type)->pluck('id')->toArray())
                ->where('actions.action_type_id', ActionType::firstWhere('name', $this->action_type)->id)
                ->whereDate('completed_at', '<', $this->dates['start'])
                ->count();

            $this->goal = Goal::query()
                ->whereIn('type_id', Type::whereIn('name', array_values($this->document_type))->pluck('id')->all())
                ->where('action_type_id', ActionType::firstWhere('name', $this->action_type)->id)
                ->whereDate('finish_at', '<', $this->dates['start'])
                ->sum('target');

            $this->percentage = 0;
            if ($this->goal > 0) {
                $this->percentage = (intval(($this->total / $this->goal) * 100));
            }
        }

        return view('livewire.admin.progress-matrix.past-work');
    }

    public function load()
    {
        $this->readyToLoad = true;
    }
}
