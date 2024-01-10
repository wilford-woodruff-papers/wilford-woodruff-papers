<?php

namespace App\Filament\Widgets;

use App\Models\Action;
use App\Models\ActionType;
use App\Models\Page;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Illuminate\Support\Number;

class ActionsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $types = ActionType::query()->where('type', 'Documents')->get();

        $stats = [];
        foreach ($types as $key => $type) {
            $stats[] = BaseWidget\Stat::make(
                $type->name.' Completed',
                Number::format(
                    Action::query()
                        ->where('action_type_id', $type->id)
                        ->where('actionable_type', Page::class)
                        ->whereNotNull('completed_at')
                        ->whereNotNull('completed_by')
                        ->count()
                )
            );
            $stats[] = BaseWidget\Stat::make(
                $type->name.' In Progress',
                Number::format(
                    Action::query()
                        ->where('action_type_id', $type->id)
                        ->where('actionable_type', Page::class)
                        ->whereNotNull('assigned_at')
                        ->whereNotNull('assigned_to')
                        ->whereNull('completed_at')
                        ->whereNull('completed_by')
                        ->count()
                )
            );
            $stats[] = BaseWidget\Stat::make(
                $type->name.' Needed',
                Number::format(
                    Page::query()
                        ->whereRelation('item', 'type_id', '!=', null)
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
                        ->count()
                    //                    Action::query()
                    //                        ->where('action_type_id', $type->id)
                    //                        ->where('actionable_type', Page::class)
                    //                        ->whereNotNull('assigned_at')
                    //                        ->whereNotNull('assigned_to')
                    //                        ->whereNull('completed_at')
                    //                        ->whereNull('completed_by')
                    //                        ->count()
                )
            );
        }

        return $stats;
    }
}
