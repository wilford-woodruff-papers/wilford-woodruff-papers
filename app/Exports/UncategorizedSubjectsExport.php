<?php

namespace App\Exports;

use App\Models\Subject;
use App\Models\User;
use App\Notifications\ExportFailedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Excel;

class UncategorizedSubjectsExport implements FromQuery, ShouldQueue, WithHeadings, WithMapping
{
    use Exportable;

    public $user;

    /**
     * Optional Writer Type
     */
    private $writerType = Excel::CSV;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function query()
    {
        if (now()->isMonday()) {
            $period = now()->subDays(7);
        } else {
            $period = now()->subDays(1);
        }

        return Subject::query()
            ->select([
                'id',
                'name',
                'slug',
                'created_at',
            ])
            ->where('created_at', '>', $period)
            ->whereDoesntHave('category');
    }

    public function failed(\Throwable $exception): void
    {
        logger()->error($exception->getMessage());
        $this->user->notify(new ExportFailedNotification());
    }

    public function headings(): array
    {
        return [
            'Internal ID',
            'Name',
            'Nova URL',
            'Public URL',
        ];
    }

    public function map($item): array
    {
        return [
            $item->id,
            $item->name,
            url('/nova/resources/subjects/'.$item->id),
            route('subjects.show', ['subject' => $item->slug]),
        ];
    }
}
