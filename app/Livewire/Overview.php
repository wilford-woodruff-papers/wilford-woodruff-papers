<?php

namespace App\Livewire;

use App\Models\Action;
use App\Models\ActionType;
use App\Models\Page;
use App\Models\Type;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class Overview extends Component
{
    public $stats = [];

    public $totalPages = [];

    public $publishingStatus = [];

    public $statuses = [
        'Completed',
        'In Progress',
        'Overdue',
        'Not Started',
    ];

    public $statusMap = [
        'Completed' => 'completed',
        'In Progress' => 'in_progress',
        'Overdue' => 'overdue',
        'Not Started' => 'not_started',
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
            ->ordered()
            ->get();
        $this->docTypes = Type::all();

        foreach ($this->typesMap as $key => $types) {
            $this->publishingStatus[$key] = Cache::remember(str('publishing-status-'.$key)->slug(), 600, function () use ($types) {
                return Page::query()
                    ->select('id')
                    ->withCount(['publishing_tasks'])
                    ->whereHas('item', function ($query) use ($types) {
                        $query->whereHas('type', function ($query) use ($types) {
                            $query->whereIn('name', $types);
                        });
                    })
                    ->toBase()
                    ->get()
                    ->groupBy(function ($item, int $key) {
                        return $item->publishing_tasks_count;
                    })
                    //->groupBy('publishing_tasks_count')
                    ->map(function ($item, $key) {
                        return ['task_count' => (4 - $key).' '.str('Task')->plural((4 - $key)), 'page_count' => $item?->count()];
                    });
            });

            $this->totalPages[$key] = Cache::remember(str('total-pages-'.$key)->slug(), 600, function () use ($types) {
                return Page::query()
                    ->whereHas('item', function ($query) use ($types) {
                        $query->whereHas('type', function ($query) use ($types) {
                            $query->whereIn('name', $types);
                        });
                    })
                    ->count();
            });

            foreach ($this->types as $type) {
                $this->stats[$key][$type->name]['Completed'] = Cache::remember(str('stats-'.$key.'-'.$type->name.'-completed')->slug(), 600, function () use ($types, $type) {
                    return Action::query()
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
                });

                $this->stats[$key][$type->name]['In Progress'] = Cache::remember(str('stats-'.$key.'-'.$type->name.'-in-progress')->slug(), 600, function () use ($types, $type) {
                    return Action::query()
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
                });

                $this->stats[$key][$type->name]['Not Started'] = $this->totalPages[$key] -
                    ($this->stats[$key][$type->name]['Completed'] + $this->stats[$key][$type->name]['In Progress']);

                $this->stats[$key][$type->name]['Overdue'] = Cache::remember(str('stats-'.$key.'-'.$type->name.'-overdue')->slug(), 600, function () use ($types, $type) {
                    return Action::query()
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
                });

            }
        }

        return view('livewire.overview');
    }
}
