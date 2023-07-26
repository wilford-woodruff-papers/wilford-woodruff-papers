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

class PlacesExport implements FromQuery, ShouldQueue, WithMapping, WithHeadings
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
                $query->where('name', 'Places');
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
            'Name',
            'Address',
            'Country',
            'State or Province',
            'County',
            'City',
            'Specific Place',
            'Modern Location',
            'Visited',
            'Mentioned Only',
            'Latitude',
            'Longitude',
            'Website URL',
            'Total Usage Count',
        ];
    }

    public function map($place): array
    {
        return [
            $place->id,
            $place->name,
            $place->address,
            $place->country,
            $place->state_province,
            $place->county,
            $place->city,
            $place->specific_place,
            $place->modern_location,
            $place->visited,
            $place->mentioned,
            $place->latitude,
            $place->longitude,
            route('subjects.show', ['subject' => $place->slug]),
            $place->total_usage_count,
        ];
    }
}
