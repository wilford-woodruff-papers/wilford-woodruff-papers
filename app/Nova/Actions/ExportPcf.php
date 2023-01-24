<?php

namespace App\Nova\Actions;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel;

class ExportPcf extends DownloadExcel implements WithMapping, WithHeadings
{
    public $name = 'PCF Export';

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Unique Identifier',
            'Document Type',
            'Name',
            'Database Search',
            'Database Link',
            'Images Uploaded to FTP',
            'Completed Transcriptions',
            '2LV Assigned',
            '2LV Completion Date',
            'Subject Links Assigned',
            'Subject Links Completed',
            'Date Tags Completed',
            'Stylization Assigned',
            'Stylization Completed',
            'Topic Tagging Assigned',
            'Date Topic Tagging Assigned',
            'Date Topic Tagging Completed',
            'Pages',
        ];
    }

    /**
     * @param $item
     * @return array
     */
    public function map($item): array
    {
        $item->load(['type', 'actions', 'actions.type', 'actions.assignee', 'actions.finisher']);
        $item->loadCount('pages');

        return [
            ((strlen($item->pcf_unique_id_full) > 2) ? $item->pcf_unique_id_full : ''),
            $item->type?->name,
            $item->name,
            route('admin.dashboard.document.index', ['filters[search]' => $item->name]),
            route('admin.dashboard.document', ['item' => $item->uuid]),
            ((! empty($item->ftp_slug)) ? 'https://fromthepage.com/woodruff/woodruffpapers/'.$item->ftp_slug : ''),
            $item->actions->firstWhere('type.name', 'Transcription')?->completed_at?->toDateString(),
            $item->actions->firstWhere('type.name', 'Verification')?->finisher?->name,
            $item->actions->firstWhere('type.name', 'Verification')?->completed_at?->toDateString(),
            $item->actions->firstWhere('type.name', 'Subject Tagging')?->finisher?->name,
            $item->actions->firstWhere('type.name', 'Subject Tagging')?->completed_at?->toDateString(),
            $item->actions->firstWhere('type.name', 'Date Tagging')?->finisher?->name,
            $item->actions->firstWhere('type.name', 'Stylization')?->finisher?->name,
            $item->actions->firstWhere('type.name', 'Stylization')?->completed_at?->toDateString(),
            $item->actions->firstWhere('type.name', 'Topic Tagging')?->finisher?->name,
            $item->actions->firstWhere('type.name', 'Topic Tagging')?->assigned_at?->toDateString(),
            $item->actions->firstWhere('type.name', 'Topic Tagging')?->completed_at?->toDateString(),
            $item->pages_count,
        ];
    }
}
