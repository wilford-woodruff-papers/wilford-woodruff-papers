<?php

namespace App\Filament\Resources\UnknownPeopleResource\Pages;

use App\Filament\Exports\UnknownPeopleExporter;
use App\Filament\Resources\UnknownPeopleResource;
use Filament\Actions;
use Filament\Actions\Exports\Models\Export;
use Filament\Resources\Pages\ListRecords;

class ListUnknownPeople extends ListRecords
{
    protected static string $resource = UnknownPeopleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\ExportAction::make()
                ->exporter(UnknownPeopleExporter::class)
                ->fileName(fn (Export $export): string => "unidentified-people-{$export->getKey()}")
                ->chunkSize(500),
        ];
    }
}
