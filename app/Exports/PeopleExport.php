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

class PeopleExport implements FromQuery, ShouldQueue, WithMapping, WithHeadings
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
            ->with([
                'category',
            ])
            ->withCount([
                'pages',
            ])
            ->whereRelation('category', function (Builder $query) {
                $query->where('name', 'People');
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
            'Unique ID',
            'Family Search ID',
            'Name',
            'First Name',
            'Middle Name',
            'Last Name',
            'Suffix',
            'Biography',
            'Footnotes',
            'Reference',
            'Relationship',
            'Birth Date',
            'Baptism Date',
            'Death Date',
            'Life Years',
            'Slug',
            'Categories',
            'Mentions'.
            'Website URL',
        ];
    }

    public function map($person): array
    {
        return [
            $person->id,
            $person->unique_id,
            $person->pid,
            $person->name,
            $person->first_name,
            $person->middle_name,
            $person->last_name,
            $person->suffix,
            $person->bio,
            $person->footnotes,
            $person->reference,
            $person->relationship,
            $person->birth_date,
            $person->baptism_date,
            $person->death_date,
            $person->life_years,
            $person->slug,
            $person->category->pluck('name')->implode('|'),
            $person->pages_count,
            route('subjects.show', ['subject' => $person->slug]),
        ];
    }
}
