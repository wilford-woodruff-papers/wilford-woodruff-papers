<?php

namespace App\Nova\Actions;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel;

class ExportItems extends DownloadExcel implements WithMapping, WithHeadings
{
    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Internal ID',
            'Document Type',
            'Enabled',
            'Name',
            'Website URL',
            'FTP URL',
        ];
    }

    /**
     * @param $item
     * @return array
     */
    public function map($item): array
    {
        return [
            $item->id,
            $item->type?->name,
            $item->enabled,
            $item->name,
            route('documents.show', ['item' => $item->uuid]),
            (! empty($item->ftp_slug)) ? 'https://fromthepage.com/woodruff/woodruffpapers/'.$item->ftp_slug : '',
        ];
    }
}
