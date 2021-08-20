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

class ExportPages extends DownloadExcel implements WithMapping, WithHeadings
{

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Internal ID',
            'Document Type',
            'Parent ID',
            'Parent Name',
            'UUID',
            'Name',
            'URL',
            'Original Transcript',
            'Text Only Transcript',
        ];
    }

    /**
     * @param $item
     *
     * @return array
     */
    public function map($page): array
    {
        $page->load('item');
        return [
            $page->id,
            optional(optional($page->parent)->type)->name,
            $page->parent_item_id,
            $page->parent->name,
            $page->uuid,
            $page->name,
            route('pages.show', ['item' => $page->item->uuid , 'page' => $page->uuid]),
            $page->transcript,
            strip_tags($page->transcript),
        ];
    }

}
