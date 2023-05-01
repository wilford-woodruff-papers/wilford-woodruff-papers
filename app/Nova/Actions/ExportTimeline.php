<?php

namespace App\Nova\Actions;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel;

class ExportTimeline extends DownloadExcel implements WithMapping, WithHeadings
{
    public $name = 'Timeline Export';

    public function headings(): array
    {
        return [
            'ID',
            'Headline',
            'Description',
            'Start Date',
            'Start Year',
            'Start Month',
            'Start Day',
            'End Date',
            'End Year',
            'End Month',
            'End Day',
            'Group',
            'Type',
            'Items',
            'Pages',
            'Photos',
            'Media',
        ];
    }

    public function map($item): array
    {
        return [
            $item->id,
            $item->headline,
            $item->text,
            $item->start_at?->toDateString(),
            $item->start_year,
            $item->start_month,
            $item->start_day,
            $item->end_at?->toDateString(),
            $item->end_year,
            $item->end_month,
            $item->end_day,
            $item->group,
            $item->type,
            $item->items->pluck('name')->join('|'),
            $item->pages->pluck('name')->join('|'),
            $item->photos->pluck('title')->join('|'),
            $item->media->pluck('name')->join('|'),
        ];
    }
}
