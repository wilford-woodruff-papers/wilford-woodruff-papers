<?php

namespace App\Filament\Resources\ComeFollowMeEventsResource\Pages;

use App\Filament\Resources\ComeFollowMeEventsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditComeFollowMeEvents extends EditRecord
{
    protected static string $resource = ComeFollowMeEventsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
