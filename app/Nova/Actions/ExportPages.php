<?php

namespace App\Nova\Actions;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
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
            'Website URL',
            'Short URL',
            'Image URL',
            'Original Transcript',
            'Text Only Transcript',
        ];
    }

    /**
     * @param $item
     * @return array
     */
    public function map($page): array
    {
        $page->load('item');

        return [
            $page->id,
            optional($page->parent?->type)->name,
            $page->parent_item_id,
            $page->parent->name,
            $page->uuid,
            $page->name,
            route('pages.show', ['item' => $page->item->uuid, 'page' => $page->uuid]),
            route('short-url.page', ['page' => $page->hashid]),
            $page->getFirstMedia()?->getUrl(),
            $page->transcript,
            strip_tags($page->transcript),
        ];
    }
}
