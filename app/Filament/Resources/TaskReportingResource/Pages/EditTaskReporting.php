<?php

namespace App\Filament\Resources\TaskReportingResource\Pages;

use App\Filament\Resources\TaskReportingResource;
use Filament\Resources\Pages\EditRecord;

class EditTaskReporting extends EditRecord
{
    protected static string $resource = TaskReportingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //Actions\DeleteAction::make(),
        ];
    }
}
