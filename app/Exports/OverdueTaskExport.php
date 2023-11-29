<?php

namespace App\Exports;

use App\Models\Action;
use App\Models\ActionType;
use App\Models\Item;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Excel;

class OverdueTaskExport implements FromQuery, ShouldQueue, WithMapping, WithHeadings
{
    use Exportable;

    public $user;

    /**
     * Optional Writer Type
     */
    private $writerType = Excel::XLSX;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function query()
    {
        return Action::query()
            ->with([
                'actionable',
                'actionable.type',
                'assignee',
                'type',
            ])
            ->whereNotNull('assigned_at')
            ->whereNull('completed_at')
            ->where('actionable_type', Item::class)
            ->where('assigned_at', '<', now()->subDays(14))
            ->whereNotIn('action_type_id',
                ActionType::query()
                    ->whereIn('name', [
                        'Publish',
                    ])
                    ->pluck('id')
            );
    }

    public function failed(\Throwable $exception): void
    {
        logger()->error($exception->getMessage());
        $this->user->notify(new ExportFailedNotification());
    }

    public function headings(): array
    {
        return [
            'Action',
            'Item Name',
            'Doc Type',
            'Date Assigned',
            'Assigned To',
            'Email',
            'URL',
        ];
    }

    public function map($action): array
    {
        return [
            $action->type?->name,
            $action->actionable?->name,
            $action->actionable?->type?->name,
            $action->assigned_at?->toDateString(),
            $action->assignee?->name,
            $action->assignee?->email,
            $action->actionable ? route('admin.dashboard.document', ['item' => $action->actionable?->uuid]) : '',
        ];
    }
}
