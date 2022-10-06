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
            'Genre/Date or Title/Section on FTP',
            'New Journal Title',
            'Images Uploaded to FTP',
            'Completed Transcriptions (Uploaded to FTP)',
            '2LV Assigned',
            '2LV Completion Date',
            'Subject Links Assigned',
            'Subject Links Completed',
            'Date Tags Completed',
            'Stylization Assigned',
            'Stylization Completed',
            'Published on Website',
            'Reviewed on Website',
            'Topic Tagging Assigned',
            'Date Topic Tagging Assigned',
            'Date Topic Tagging Completed',
            'Pages',
            '3LV',
            'URL of Column E',
        ];
    }

    /**
     * @param $item
     * @return array
     */
    public function map($item): array
    {
        $item->load('actions', 'actions.type', 'actions.assignee', 'actions.finisher');
        $item->loadCount('pages');

        return [
            $item->pcf_unique_id,
            $item->name,
            '',
            '=HYPERLINK("'.'https://fromthepage.com/woodruff/woodruffpapers/'.$item->slug.'", "Link")',
            $item->actions->firstWhere('type.name', 'Transcription')?->completed_at?->toDateString(),
            $item->actions->firstWhere('type.name', 'Verification')?->finisher?->name,
            $item->actions->firstWhere('type.name', 'Verification')?->completed_at?->toDateString(),
            $item->actions->firstWhere('type.name', 'Subject Tagging')?->finisher?->name,
            $item->actions->firstWhere('type.name', 'Subject Tagging')?->completed_at?->toDateString(),
            $item->actions->firstWhere('type.name', 'Date Tagging')?->finisher?->name,
            $item->actions->firstWhere('type.name', 'Stylization')?->finisher?->name,
            $item->actions->firstWhere('type.name', 'Stylization')?->completed_at?->toDateString(),
            '',
            '',
            $item->actions->firstWhere('type.name', 'Topic Tagging')?->finisher?->name,
            $item->actions->firstWhere('type.name', 'Topic Tagging')?->assigned_at?->toDateString(),
            $item->actions->firstWhere('type.name', 'Topic Tagging')?->completed_at?->toDateString(),
            $item->pages_count,
            '',
            'https://fromthepage.com/woodruff/woodruffpapers/'.$item->slug,
        ];
    }
}
