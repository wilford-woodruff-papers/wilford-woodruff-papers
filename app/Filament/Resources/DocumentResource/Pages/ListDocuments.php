<?php

namespace App\Filament\Resources\DocumentResource\Pages;

use App\Filament\Exports\DocumentExporter;
use App\Filament\Imports\DocumentIntroductionImporter;
use App\Filament\Resources\DocumentResource;
use Filament\Actions;
use Filament\Actions\Exports\Models\Export;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Actions\BulkActionGroup;

class ListDocuments extends ListRecords
{
    protected static string $resource = DocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\ExportAction::make()
                ->exporter(DocumentExporter::class)
                ->fileName(fn (Export $export): string => "document-metadata-{$export->getKey()}")
                ->chunkSize(500),
            BulkActionGroup::make([
                Actions\ImportAction::make()->importer(DocumentIntroductionImporter::class),
            ]),
        ];
    }
}
