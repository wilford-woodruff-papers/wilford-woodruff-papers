<?php

namespace App\Filament\Resources\AssignedTaskResource\Pages;

use App\Filament\Resources\AssignedTaskResource;
use Filament\Resources\Pages\EditRecord;

class EditAssignedTask extends EditRecord
{
    protected static string $resource = AssignedTaskResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }
}
