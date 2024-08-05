<?php

namespace App\Filament\Resources\PeopleResource\Pages;

use App\Filament\Exports\PeopleExporter;
use App\Filament\Resources\PeopleResource;
use Filament\Actions;
use Filament\Actions\Exports\Models\Export;
use Filament\Resources\Pages\ListRecords;

class ListPeople extends ListRecords
{
    protected static string $resource = PeopleResource::class;

    protected static ?string $title = 'People';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\ExportAction::make()
                ->exporter(PeopleExporter::class)
                ->fileName(fn (Export $export): string => "people-{$export->getKey()}")
                ->chunkSize(500),
        ];
    }
}
