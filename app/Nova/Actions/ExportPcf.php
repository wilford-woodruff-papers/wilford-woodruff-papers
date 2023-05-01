<?php

namespace App\Nova\Actions;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel;

class ExportPcf extends DownloadExcel implements WithMapping, WithHeadings
{
    public $name = 'PCF Export';

    public function headings(): array
    {
        return [
            'Unique Identifier',
            'Document Type',
            'Name',
            'Database Search',
            'Database Link',
            'Images Uploaded to FTP',

            'Transcription Assigned To',
            'Transcription Assigned Date',
            'Transcription Completed Date',

            '2LV Assigned To',
            '2LV Assigned Date',
            '2LV Completed Date',

            'Subject Links Assigned To',
            'Subject Links Assigned Date',
            'Subject Links Completed Date',

            'Date Tagging Assigned To',
            'Date Tagging Assigned Date',
            'Date Tagging Completed Date',

            'Stylization Assigned To',
            'Stylization Assigned Date',
            'Stylization Completed Date',

            'Topic Tagging Assigned To',
            'Topic Tagging Assigned Date',
            'Topic Tagging Completed Date',

            'Quote Tagging Assigned To',
            'Quote Tagging Assigned Date',
            'Quote Tagging Completed Date',

            'Published Date',

            'Pages',
        ];
    }

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

            $item->actions->firstWhere('type.name', 'Transcription')?->assignee?->name,
            $item->actions->firstWhere('type.name', 'Transcription')?->assigned_at?->toDateString(),
            $item->actions->firstWhere('type.name', 'Transcription')?->completed_at?->toDateString(),

            $item->actions->firstWhere('type.name', 'Verification')?->assignee?->name,
            $item->actions->firstWhere('type.name', 'Verification')?->assigned_at?->toDateString(),
            $item->actions->firstWhere('type.name', 'Verification')?->completed_at?->toDateString(),

            $item->actions->firstWhere('type.name', 'Subject Tagging')?->assignee?->name,
            $item->actions->firstWhere('type.name', 'Subject Tagging')?->assigned_at?->toDateString(),
            $item->actions->firstWhere('type.name', 'Subject Tagging')?->completed_at?->toDateString(),

            $item->actions->firstWhere('type.name', 'Date Tagging')?->assignee?->name,
            $item->actions->firstWhere('type.name', 'Date Tagging')?->assigned_at?->toDateString(),
            $item->actions->firstWhere('type.name', 'Date Tagging')?->completed_at?->toDateString(),

            $item->actions->firstWhere('type.name', 'Stylization')?->assignee?->name,
            $item->actions->firstWhere('type.name', 'Stylization')?->assigned_at?->toDateString(),
            $item->actions->firstWhere('type.name', 'Stylization')?->completed_at?->toDateString(),

            $item->actions->firstWhere('type.name', 'Topic Tagging')?->assignee?->name,
            $item->actions->firstWhere('type.name', 'Topic Tagging')?->assigned_at?->toDateString(),
            $item->actions->firstWhere('type.name', 'Topic Tagging')?->completed_at?->toDateString(),

            $item->actions->firstWhere('type.name', 'Quote Tagging')?->assignee?->name,
            $item->actions->firstWhere('type.name', 'Quote Tagging')?->assigned_at?->toDateString(),
            $item->actions->firstWhere('type.name', 'Quote Tagging')?->completed_at?->toDateString(),

            $item->actions->firstWhere('type.name', 'Publish')?->completed_at?->toDateString(),

            $item->pages_count,
        ];
    }
}
