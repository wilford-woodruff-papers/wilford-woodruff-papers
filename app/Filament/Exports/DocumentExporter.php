<?php

namespace App\Filament\Exports;

use App\Models\Item;
use App\Models\Property;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Support\Facades\Cache;

class DocumentExporter extends Exporter
{
    protected static ?string $model = Item::class;

    public static function getColumns(): array
    {
        $properties = Cache::remember('properties', 3600, function () {
            return Property::query()
                ->where('enabled', true)
                ->orderBy('name')
                ->get();
        });

        $columns = $properties->map(function ($property) {
            return ExportColumn::make('values-'.$property->slug)
                ->label($property->name)
                ->formatStateUsing(function (Item $record) use ($property) {
                    $record->load([
                        'values',
                        'values.repository',
                        'values.source',
                        'values.copyrightstatus',
                    ]);
                    $value = $record->values->where('property_id', $property->id)->first();

                    return match ($property->type) {
                        'relationship' => $value?->{str($property->relationship)->lower()}?->name ?? '',
                        default => $value->value ?? '',
                    };
                });
        })
            ->toArray();

        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('pcf_unique_id_full')
                ->label('Unique ID'),
            ExportColumn::make('type.name')
                ->label('Type'),
            ExportColumn::make('name')
                ->label('Name'),
            ExportColumn::make('auto_page_count')
                ->label('# of Pages'),
            ExportColumn::make('admin_url')
                ->label('Admin URL')
                ->formatStateUsing(fn (Item $record): string => route('admin.dashboard.document.edit', ['item' => $record->uuid])),
            ExportColumn::make('ftp_slug')
                ->label('FTP URL')
                ->formatStateUsing(fn (Item $record): string => 'https://fromthepage.com/woodruff/wilford-woodruff-papers-project/'.$record->ftp_slug),
            ExportColumn::make('public_url')
                ->label('Public URL')
                ->formatStateUsing(fn (Item $record): string => route('documents.show', ['item' => $record->uuid])),
            ...$columns,
            ExportColumn::make('copyright.description')
                ->label('Copyright Status'),
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
