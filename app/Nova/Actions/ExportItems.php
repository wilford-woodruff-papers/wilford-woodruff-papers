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
     *
     * @return array
     */
    public function map($item): array
    {
        return [
            $item->id,
            $item->type->name,
            $item->enabled,
            $item->name,
            route('documents.show', ['item' => $item->uuid]),
            $item->ftp_id
        ];
    }

}
