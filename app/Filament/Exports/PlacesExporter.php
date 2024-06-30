<?php

namespace App\Filament\Exports;

use App\Models\Subject;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Queue\Middleware\WithoutOverlapping;

class PlacesExporter extends Exporter
{
    protected static ?string $model = Subject::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('Internal ID'),
            ExportColumn::make('slug')
                ->label('Admin URL')
                ->formatStateUsing(fn (Subject $record): string => url('https://wilford-woodruff-papers.test/filament/admin/places/'.$record->slug.'/edit')),
            ExportColumn::make('subject_uri')
                ->label('FTP URL'),
            ExportColumn::make('name')
                ->label('Name'),
            ExportColumn::make('place_confirmed_at')
                ->label('Confirmed At'),
            ExportColumn::make('latitude')
                ->label('Latitude'),
            ExportColumn::make('longitude')
                ->label('Longitude'),
            ExportColumn::make('country')
                ->label('Country'),
            ExportColumn::make('state_province')
                ->label('State or Province'),
            ExportColumn::make('county')
                ->label('County'),
            ExportColumn::make('city')
                ->label('City'),
            ExportColumn::make('specific_place')
                ->label('Specific Place'),
            ExportColumn::make('years')
                ->label('Years'),
            ExportColumn::make('modern_location')
                ->label('Modern Location'),
            ExportColumn::make('reference')
                ->label('Reference'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your places export has completed and '.number_format($export->successful_rows).' '.str('row')->plural($export->successful_rows).' exported.';

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
