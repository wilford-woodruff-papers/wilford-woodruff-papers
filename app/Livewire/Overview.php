<?php

namespace App\Livewire;

use App\Models\Action;
use App\Models\ActionType;
use App\Models\Page;
use App\Models\Type;
use Livewire\Component;

class Overview extends Component
{
    public $stats = [];

    public $totalPages = [];

    public $statuses = [
        'Completed',
        'In Progress',
        'Needed',
        'Overdue',
    ];

    public $statusMap = [
        'Completed' => 'completed',
        'In Progress' => 'in_progress',
        'Needed' => 'needed',
        'Overdue' => 'overdue',
    ];

    public $docTypes;

    public $types = [];

    public $typesMap = [
        'Additional' => ['Additional', 'Additional Sections'],
        'Autobiographies' => ['Autobiographies', 'Autobiography Sections'],
        'Daybooks' => ['Daybooks', 'Daybook Sections'],
        'Discourses' => ['Discourses'],
        'Journals' => ['Journals', 'Journal Sections'],
        'Letters' => ['Letters'],
    ];

    public function render()
    {
        $this->types = ActionType::query()
            ->where('type', 'Documents')
            ->get();
        $this->docTypes = Type::all();

        foreach ($this->typesMap as $key => $types) {
            $this->totalPages[$key] = Page::query()
                ->whereHas('item', function ($query) use ($types) {
                    $query->whereHas('type', function ($query) use ($types) {
                        $query->whereIn('name', $types);
                    });
                })
                ->count();
            foreach ($this->types as $type) {
                $this->stats[$key][$type->name]['Completed'] = Action::query()
                    ->whereHasMorph('actionable', [Page::class],
                        function ($query) use ($types) {
                            $query->whereHas('parent', function ($query) use ($types) {
                                $query->whereHas('type', function ($query) use ($types) {
                                    $query->whereIn('name', $types);
                                });
                            });
                        })
                    ->where('action_type_id', $type->id)
                    ->where('actionable_type', Page::class)
                    ->whereNotNull('completed_at')
                    ->whereNotNull('completed_by')
                    ->count();

                $this->stats[$key][$type->name]['In Progress'] = Action::query()
                    ->whereHasMorph('actionable', [Page::class],
                        function ($query) use ($types) {
                            $query->whereHas('parent', function ($query) use ($types) {
                                $query->whereHas('type', function ($query) use ($types) {
                                    $query->whereIn('name', $types);
                                });
                            });
                        })
                    ->where('action_type_id', $type->id)
                    ->where('actionable_type', Page::class)
                    ->whereNotNull('assigned_at')
                    ->whereNotNull('assigned_to')
                    ->whereNull('completed_at')
                    ->whereNull('completed_by')
                    ->count();

                $this->stats[$key][$type->name]['Needed'] = $this->totalPages[$key] -
                    ($this->stats[$key][$type->name]['Completed'] + $this->stats[$key][$type->name]['In Progress']);

                /*Page::query()
                ->whereHas('item', function ($query) use ($types) {
                    $query->whereHas('type', function ($query) use ($types) {
                        $query->whereIn('name', $types);
                    });
                })
                ->where(function ($query) use ($type) {
                    $query->whereDoesntHave('actions', function ($query) use ($type) {
                        $query->where('action_type_id', $type->id);
                    })
                        ->orWhereHas('actions', function ($query) use ($type) {
                            $query->where('action_type_id', $type->id)
                                ->whereNull('assigned_at')
                                ->whereNull('assigned_to');
                        });
                })
                ->count();*/

                $this->stats[$key][$type->name]['Overdue'] = Action::query()
                    ->whereHasMorph('actionable', [Page::class],
                        function ($query) use ($types) {
                            $query->whereHas('parent', function ($query) use ($types) {
                                $query->whereHas('type', function ($query) use ($types) {
                                    $query->whereIn('name', $types);
                                });
                            });
                        })
                    ->where('action_type_id', $type->id)
                    ->where('actionable_type', Page::class)
                    ->where('assigned_at', '<', now()->subDays(14))
                    ->whereNotNull('assigned_at')
                    ->whereNotNull('assigned_to')
                    ->whereNull('completed_at')
                    ->whereNull('completed_by')
                    ->count();
            }
        }

        return view('livewire.overview');
    }
}
