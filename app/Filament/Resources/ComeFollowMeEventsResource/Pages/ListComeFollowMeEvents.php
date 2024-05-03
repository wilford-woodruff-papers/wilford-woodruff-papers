<?php

namespace App\Filament\Resources\ComeFollowMeEventsResource\Pages;

use App\Filament\Resources\ComeFollowMeEventsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListComeFollowMeEvents extends ListRecords
{
    protected static string $resource = ComeFollowMeEventsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
