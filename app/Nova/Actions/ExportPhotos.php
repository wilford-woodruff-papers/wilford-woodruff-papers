<?php

namespace App\Nova\Actions;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel;

class ExportPhotos extends DownloadExcel implements WithHeadings, WithMapping
{
    public function headings(): array
    {
        return [
            'Internal ID',
            'UUID',
            'Title',
            'Original Filename',
            'URL',
            'Description',
            'Date',
            'Artist or Photographer',
            'Location',
            'Journal Reference',
            'Identification',
            'Source',
            'Notes',
            'Categories',
        ];
    }

    /**
     * @param    $item
     */
    public function map($photo): array
    {
        $photo->with([
            'media',
        ]);

        return [
            $photo->id,
            $photo->uuid,
            $photo->title,
            $photo->getFirstMedia()->file_name,
            $photo->getFirstMediaUrl(),
            $photo->description,
            $photo->date,
            $photo->artist_or_photographer,
            $photo->location,
            $photo->journal_reference,
            $photo->identification,
            $photo->source,
            $photo->notes,
            $photo->tags->pluck('name')->implode('|'),

        ];
    }
}
