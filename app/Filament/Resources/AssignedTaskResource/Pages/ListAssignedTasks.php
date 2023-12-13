<?php

namespace App\Filament\Resources\AssignedTaskResource\Pages;

use App\Filament\Resources\AssignedTaskResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAssignedTasks extends ListRecords
{
    protected static string $resource = AssignedTaskResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
