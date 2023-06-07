<?php

namespace App\Exports;

use App\Models\Subject;
use App\Models\User;
use App\Notifications\ExportFailedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Excel;

class TopicsExport implements FromQuery, ShouldQueue, WithMapping, WithHeadings
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
        return Subject::query()
            ->whereRelation('category', function (Builder $query) {
                $query->where('name', 'Index');
            })
            ->where(function ($query) {
                $query->where('tagged_count', '>', 0)
                    ->orWhere('text_count', '>', 0);
            });
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
            'Slug',
            'Name',
            'Website URL',
        ];
    }

    public function map($place): array
    {
        return [
            $place->id,
            $place->slug,
            $place->name,
            route('subjects.show', ['subject' => $place->slug]),
        ];
    }
}
