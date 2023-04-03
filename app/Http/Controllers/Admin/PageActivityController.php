<?php

namespace App\Http\Controllers\Admin;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use App\Models\Action;
use App\Models\ActionType;
use App\Models\Page;
use App\Models\Type;
use Illuminate\Http\Request;

class PageActivityController extends Controller
{
    public $typesMap = [
        'Letters' => ['Letters'],
        'Discourses' => ['Discourses'],
        'Journals' => ['Journals', 'Journal Sections'],
        'Additional' => ['Additional', 'Additional Sections'],
        'Autobiographies' => ['Autobiography Sections', 'Autobiographies'],
        'Daybooks' => ['Daybooks'],
    ];

    public function __invoke(Request $request): View
    {
        $typeIds = Type::query()->whereIn('name', $this->typesMap[$request->get('type')])->pluck('id')->toArray();
        $actionTypeId = ActionType::query()->firstWhere('name', $request->get('activity'))->id;

        $pages = Page::query()
            ->with([
                'item',
                'actions' => function ($query) use ($actionTypeId) {
                    $query->where('action_type_id', $actionTypeId);
                },
            ])
            ->whereHas('item', function ($query) use ($typeIds) {
                $query->whereIn('type_id', array_values($typeIds));
            })
            ->whereHas('actions', function ($query) use ($actionTypeId) {
                $query->where('action_type_id', $actionTypeId)
                    ->whereDate('completed_at', '>=', request()->get('start_date'))
                    ->whereDate('completed_at', '<=', request()->get('end_date'));
            })
            ->orderBy(
                Action::select('completed_at')
                    ->where('actionable_type', Page::class)
                    ->where('action_type_id', $actionTypeId)
                    ->whereDate('completed_at', '>=', request()->get('start_date'))
                    ->whereDate('completed_at', '<=', request()->get('end_date'))
                    ->whereColumn('actions.actionable_id', 'pages.id'), 'desc');

        return view('livewire.admin.page-activity', [
            'pages' => $pages->paginate(100),
        ]);
    }
}
