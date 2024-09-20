<?php

namespace App\Filament\Resources\PlaceResource\Pages;

use App\Filament\Exports\PlacesExporter;
use App\Filament\Resources\PlaceResource;
use Filament\Actions;
use Filament\Actions\Exports\Models\Export;
use Filament\Resources\Pages\ListRecords;

class ListPlaces extends ListRecords
{
    protected static string $resource = PlaceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\ExportAction::make()
                ->exporter(PlacesExporter::class)
                ->label('Export Places')
                ->fileName(fn (Export $export): string => "places-{$export->getKey()}")
                ->chunkSize(500),
        ];
    }
}
