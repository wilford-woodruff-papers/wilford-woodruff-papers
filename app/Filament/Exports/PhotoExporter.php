<?php

namespace App\Filament\Exports;

use App\Models\Photo;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Queue\Middleware\WithoutOverlapping;

class PhotoExporter extends Exporter
{
    protected static ?string $model = Photo::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('uuid')
                ->label('UUID'),
            ExportColumn::make('media.file_name')
                ->label('Filename(s)'),
            ExportColumn::make('title')
                ->label('Title'),
            ExportColumn::make('description')
                ->label('Description'),
            ExportColumn::make('date')
                ->label('Date'),
            ExportColumn::make('artist_or_photographer')
                ->label('Artist or Photographer'),
            ExportColumn::make('location')
                ->label('Location'),
            ExportColumn::make('journal_reference')
                ->label('Journal Reference'),
            ExportColumn::make('identification')
                ->label('Identification'),
            ExportColumn::make('source')
                ->label('Source'),
            ExportColumn::make('notes')
                ->label('Notes'),
            ExportColumn::make('tags.name')
                ->label('Categories'),
            ExportColumn::make('url')
                ->label('URL')
                ->state(function (Photo $record) {
                    return $record->getFirstMediaUrl('default');
                }),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your photos export has completed and '.number_format($export->successful_rows).' '.str('row')->plural($export->successful_rows).' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' '.number_format($failedRowsCount).' '.str('row')->plural($failedRowsCount).' failed to export.';
        }

        return $body;
    }

    public function getJobQueue(): ?string
    {
        return 'exports';
    }

    public function getJobMiddleware(): array
    {
        return [
            (new WithoutOverlapping("export{$this->export->getKey()}"))
                ->expireAfter(600),
        ];
    }
}
