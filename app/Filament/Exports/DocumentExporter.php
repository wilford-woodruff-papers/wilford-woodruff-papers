<?php

namespace App\Filament\Exports;

use App\Models\Item;
use App\Models\Property;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Queue\Middleware\WithoutOverlapping;

class DocumentExporter extends Exporter
{
    protected static ?string $model = Item::class;

    public static function getColumns(): array
    {

        $properties = Property::query()
            ->orderBy('name')
            ->get();
        $columns = $properties->map(function ($property) {
            return ExportColumn::make('values-'.$property->slug)
                ->label($property->name)
                ->formatStateUsing(function (Item $record) use ($property) {
                    return $record->values->where('property_id', $property->id)->first()->value ?? '';
                });
        })
            ->toArray();

        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('type.name')
                ->label('Type'),
            ExportColumn::make('name')
                ->label('Name'),
            ExportColumn::make('admin_url')
                ->label('Admin URL')
                ->formatStateUsing(fn (Item $record): string => route('admin.dashboard.document.edit', ['item' => $record->uuid])),
            ...$columns,
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your document export has completed and '.number_format($export->successful_rows).' '.str('row')->plural($export->successful_rows).' exported.';

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
