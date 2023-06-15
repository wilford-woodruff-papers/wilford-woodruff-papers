<?php

namespace App\Nova\Actions;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel;

class ExportPeople extends DownloadExcel implements WithMapping, WithHeadings
{
    public $name = 'Export People';

    public function headings(): array
    {
        return [
            'Family Search ID',
            'Full Name',
            'First Name',
            'Middle Name',
            'Last Name',
            'Suffix',
            'Alternate Names',
            'Maiden Name',
            'Category',
            'Number Occurrences',
            'URL',
            'Biography',
            'Footnotes',
            'Reference',
            'Relationship',
            'Birth Date',
            'Baptism Date',
            'Death Date',
            'Life Years',
        ];
    }

    /**
     * @param $item
     */
    public function map($subject): array
    {
        $subject->load('category');

        return [
            $subject->pid,
            $subject->name,
            $subject->first_name,
            $subject->middle_name,
            $subject->last_name,
            $subject->suffix,
            $subject->alternate_names,
            $subject->maiden_name,
            $subject->category->pluck('name')->join(';'),
            $subject->total_usage_count,
            config('app.url').'/subjects/'.$subject->slug,
            $subject->bio,
            $subject->footnotes,
            $subject->reference,
            $subject->getAttribute('relationship'),
            $subject->birth_date,
            $subject->baptism_date,
            $subject->death_date,
            $subject->life_years,
        ];
    }
}
