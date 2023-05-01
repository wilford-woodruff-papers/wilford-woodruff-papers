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
            'Item URLs',
            'Pages URLs',
            'Photo URLs',
            'Media IDs',
        ];
    }

    public function map($item): array
    {
        $item->loadMissing([
            'items',
            'pages',
            'photos',
            'media',
        ]);

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
            $item->items->transform(function ($item) {
                return route('short-url.item', ['hashid' => $item->hashid]);
            })->join('|'),
            $item->pages->transform(function ($page) {
                return route('short-url.page', ['hashid' => $page->hashid]);
            })->join('|'),
            $item->photos->transform(function ($photo) {
                return route('media.photos.show', ['photo' => $photo->uuid]);
            })->join('|'),
            $item->media->pluck('id')->join('|'),
        ];
    }
}
