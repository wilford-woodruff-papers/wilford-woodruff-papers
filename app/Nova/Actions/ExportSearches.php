<?php

namespace App\Nova\Actions;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel;

class ExportSearches extends DownloadExcel implements WithMapping, WithHeadings
{
    public function headings(): array
    {
        return [
            'Date',
            'Search Term',
            'Document Types',
            'Included People',
            'Page',
            'Referrer',
            'Data',
        ];
    }

    /**
     * @param $item
     */
    public function map($activity): array
    {
        return [
            $activity->created_at,
            $activity->description,
            collect($activity->getExtraProperty('types'))->join('|'),
            $activity->getExtraProperty('people'),
            $activity->getExtraProperty('page'),
            $activity->getExtraProperty('referrer'),
            $activity->properties,
        ];
    }
}
