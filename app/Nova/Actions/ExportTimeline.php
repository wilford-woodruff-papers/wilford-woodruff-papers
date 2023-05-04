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
            'Context',
            'Display Date',
            'Start Date',
            'End Date',
            'Description',
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
            $item->group,
            $item->manual_display_date,
            $item->start_at?->toDateString(),
            $item->end_at?->toDateString(),
            $item->text,
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
