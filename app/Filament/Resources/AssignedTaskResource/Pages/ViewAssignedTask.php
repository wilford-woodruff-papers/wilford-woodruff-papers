<?php

namespace App\Filament\Resources\AssignedTaskResource\Pages;

use App\Filament\Resources\AssignedTaskResource;
use Filament\Resources\Pages\ViewRecord;

class ViewAssignedTask extends ViewRecord
{
    protected static string $resource = AssignedTaskResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
