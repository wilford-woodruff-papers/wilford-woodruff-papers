<?php

namespace App\Nova\Actions;

use App\Exports\PageExport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel;

class ExportSearches extends DownloadExcel implements WithMapping, WithHeadings
{

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Date',
            'Search Term',
            'Document Types',
            'Included People',
            'Page',
            'Referrer',
            'Data'
        ];
    }

    /**
     * @param $item
     *
     * @return array
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
