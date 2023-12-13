<?php

namespace App\Filament\Actions\Tables\Subjects;

use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Model;

class ClaimSubject extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'claim-subject';
    }

    public function getLabel(): ?string
    {
        return 'Claim';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->button()
            ->action(function (Model $record): void {
                if (empty($record->researcher_id)) {
                    $record->researcher_id = auth()->user()->id;
                    $record->save();
                    $this->success();
                } else {
                    $this->danger();
                }
            });

    }
}
