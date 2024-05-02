<?php

namespace App\Filament\Resources\ComeFollowMeResource\Pages;

use App\Filament\Resources\ComeFollowMeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditComeFollowMe extends EditRecord
{
    protected static string $resource = ComeFollowMeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
