<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UnknownPeopleResource\Pages;
use App\Models\PeopleIdentification;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class UnknownPeopleResource extends Resource
{
    protected static ?string $model = PeopleIdentification::class;

    protected static ?string $navigationGroup = 'Subjects';

    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\IconColumn::make('correction_needed')
                    ->boolean()
                    ->trueIcon('heroicon-o-exclamation-triangle')
                    ->falseIcon('')
                    ->color('warning')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('researcher.name')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('first_middle_name')
                    ->label('First & Middle Name or Initials')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('last_name')
                    ->label('Surname or Initial')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('link_to_ftp')
                    ->formatStateUsing(fn (string $state): string => ! empty($state) ? 'fromthepage.com' : '')
                    ->url(fn (PeopleIdentification $record) => $record->link_to_ftp, true)
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('guesses')
                    ->label('Guesses or Notes (if any)')
                    ->state(function (Model $record) {
                        return trim(strip_tags($record->guesses));
                    })
                    ->limit(50)
                    ->toggleable(),
                Tables\Columns\TextColumn::make('location')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('completed_at')
                    ->label('Date Completed')
                    ->date('D, d M Y')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('notes')
                    ->label('Research Notes')
                    ->state(function (Model $record) {
                        return trim(strip_tags($record->guesses));
                    })
                    ->limit(50)
                    ->toggleable(),
                Tables\Columns\IconColumn::make('cant_be_identified')
                    ->label('Identifiable')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->date('D, d M Y H:i:s')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUnknownPeople::route('/'),
            'create' => Pages\CreateUnknownPeople::route('/create'),
            'edit' => Pages\EditUnknownPeople::route('/{record}/edit'),
        ];
    }
}
