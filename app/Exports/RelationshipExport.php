<?php

namespace App\Exports;

use App\Models\Relationship;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class RelationshipExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    public function query()
    {
        return Relationship::query()
            ->with([
                'person',
                'person.public_categories',
            ])
            ->where('user_id', auth()->id());
    }

    public function map($relationship): array
    {
        return [
            $relationship->person->name,
            $relationship->description,
            $relationship->distance,
            $relationship->person->public_categories->implode('name', ', '),
            route('subjects.show', ['subject' => $relationship->person->slug]),
            'https://www.familysearch.org/tree/person/details/'.$relationship->person->pid,
        ];
    }

    public function headings(): array
    {
        return [
            'Name',
            'Relationship',
            'Distance',
            'Categories',
            'Wilford Woodruff Papers Link',
            'FamilySearch Link',
        ];
    }
}
