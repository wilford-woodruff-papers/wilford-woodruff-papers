<?php

namespace App\Nova\Actions;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel;

class ExportContestEntries extends DownloadExcel implements WithHeadings, WithMapping
{
    public function headings(): array
    {
        return [
            'Internal ID',
            'Title',
            'Division',
            'Category',
            'Medium',
            'Connection',
            'Link',
            'File URL',
            'Date',
        ];
    }

    /**
     * @param    $item
     */
    public function map($entry): array
    {
        $entry->load([
            'contestants',
        ]);

        return [
            $entry->id,
            $entry->title,
            $entry->division,
            $entry->category,
            $entry->medium,
            $entry->connection,
            $entry->link,
            $entry->getFirstMediaUrl('art'),
            $entry->created_at->toDateTimeString(),
        ];
    }
}
