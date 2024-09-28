<?php

namespace App\Nova\Actions;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel;

class ExportPagesAlternate extends DownloadExcel implements WithHeadings, WithMapping
{
    public $name = 'Page Export (for LaJean)';

    public function headings(): array
    {
        return [
            'Internal ID',
            'Number',
            'Entered By',
            'Date Entered',
            'FromThePage URL',
            'CHL Catalog Image',
            'Date Sent to LaJean',
            'Date LaJean Completed',
            'Document Type',
            'Title of the work containing the page',
            'Title of the page',
            'Notes',
            'Assigned To',
        ];
    }

    /**
     * @param    $item
     */
    public function map($page): array
    {
        $page->load([
            'item',
            'item.type',
        ]);

        return [
            $page->id,
            '',
            '',
            '',
            $page->ftp_link,
            '',
            '',
            '',
            $page->item?->type?->name,
            $page->item?->name,
            $page->name,
            '',
            '',
        ];
    }
}
