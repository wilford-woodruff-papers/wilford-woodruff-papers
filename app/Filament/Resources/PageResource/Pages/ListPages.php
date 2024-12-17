<?php

namespace App\Filament\Resources\PageResource\Pages;

use App\Filament\Exports\PageExporter;
use App\Filament\Resources\PageResource;
use Filament\Actions;
use Filament\Actions\Exports\Models\Export;
use Filament\Resources\Pages\ListRecords;

class ListPages extends ListRecords
{
    protected static string $resource = PageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\ExportAction::make()
                ->exporter(PageExporter::class)
                ->fileName(fn (Export $export): string => "pages-{$export->getKey()}")
                ->chunkSize(500),
        ];
    }
}
