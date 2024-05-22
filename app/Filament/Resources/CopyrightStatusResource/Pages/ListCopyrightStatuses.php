<?php

namespace App\Filament\Resources\CopyrightStatusResource\Pages;

use App\Filament\Resources\CopyrightStatusResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCopyrightStatuses extends ListRecords
{
    protected static string $resource = CopyrightStatusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
