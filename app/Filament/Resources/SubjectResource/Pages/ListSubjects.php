<?php

namespace App\Filament\Resources\SubjectResource\Pages;

use App\Filament\Exports\SubjectExporter;
use App\Filament\Resources\SubjectResource;
use Filament\Actions;
use Filament\Actions\Exports\Models\Export;
use Filament\Resources\Pages\ListRecords;

class ListSubjects extends ListRecords
{
    protected static string $resource = SubjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\ExportAction::make()
                ->exporter(SubjectExporter::class)
                ->fileName(fn (Export $export): string => "subject-{$export->getKey()}")
                ->chunkSize(500),
        ];
    }
}
