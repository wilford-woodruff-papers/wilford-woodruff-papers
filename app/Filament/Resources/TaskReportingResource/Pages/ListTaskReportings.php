<?php

namespace App\Filament\Resources\TaskReportingResource\Pages;

use App\Filament\Resources\TaskReportingResource;
use App\Models\Page;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListTaskReportings extends ListRecords
{
    protected static string $resource = TaskReportingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [

        ];
    }

    public function getDefaultActiveTab(): string|int|null
    {
        return 'incomplete';
    }

    public function getTabs(): array
    {
        return [
            'incomplete' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('actionable_type', Page::class)->whereNotNull('assigned_at')->whereNull('completed_at')),
            'overdue' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('actionable_type', Page::class)->whereNotNull('assigned_at')->whereNull('completed_at')->where('assigned_at', '<', now()->subDays(14))),
            'abandoned' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('actionable_type', Page::class)->whereNotNull('assigned_at')->whereNull('completed_at')->whereHas('assignee', function ($query) {
                    $query->whereDoesntHave('roles');
                })),
            'completed' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('actionable_type', Page::class)->whereNotNull('completed_at')),
            'all' => Tab::make()->modifyQueryUsing(fn (Builder $query) => $query->where('actionable_type', Page::class)),
        ];
    }
}
