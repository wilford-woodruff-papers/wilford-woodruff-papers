<?php

namespace App\Filament\Actions\Tables;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Filament\Tables\Actions\BulkAction;
use Illuminate\Support\Collection;

class UpdateSubjectValue extends BulkAction
{
    public string $model;

    public static function getDefaultName(): ?string
    {
        return 'update-subject-value';
    }

    public function setModel($model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getLabel(): ?string
    {
        return 'Update Value';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->icon('heroicon-o-pencil')
            ->form([
                Repeater::make('fields')
                    ->columns(3)
                    ->schema([
                        Select::make('field')
                            ->required()
                            ->live()
                            ->options([
                                'pid' => 'PID',
                                'short_bio' => 'Short Bio',
                            ]),
                        TextInput::make('new_value'),
                        Select::make('behavior')
                            ->required()
                            ->options([
                                'all' => 'Update all',
                                'new' => 'Only update empty values',
                            ]),
                        Checkbox::make('mark_short_bio_completed')
                            ->label('Mark Short Bio Completed')
                            ->visible(function (Get $get) {
                                return $get('field') === 'short_bio';
                            }),
                    ]),
            ])
            ->action(function (Collection $records, array $data): void {
                foreach ($data['fields'] as $field) {
                    $updates = [$field['field'] => $field['new_value']];
                    if (array_key_exists('mark_short_bio_completed', $field) && $field['mark_short_bio_completed']) {
                        $updates['short_bio_completed_at'] = now();
                    }
                    $this->model::whereIn('id', $records->pluck('id')->toArray())
                        ->when($field['behavior'] === 'new', function ($query) use ($field) {
                            $query->whereNull($field['field']);
                        })
                        ->update($updates);
                }
            });

    }
}
