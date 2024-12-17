<?php

namespace App\Filament\Exports;

use App\Models\Item;
use App\Models\Page;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Queue\Middleware\WithoutOverlapping;

class PageExporter extends Exporter
{
    protected static ?string $model = Item::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('parent.name')
                ->label('Document Name'),
            ExportColumn::make('name')
                ->label('Page'),
            ExportColumn::make('public_url')
                ->label('Public URL')
                ->formatStateUsing(fn (Page $record): string => route('short-url.page', ['hashid' => $record->hashid()])),
            ExportColumn::make('transcript')
                ->label('Transcript'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your page export has completed and '.number_format($export->successful_rows).' '.str('row')->plural($export->successful_rows).' exported.';

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
