<?php

namespace App\Filament\Resources\DocumentResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class RealPagesRelationManager extends RelationManager
{
    protected static string $relationship = 'containerPages';

    protected static ?string $title = 'Pages';

    public static function canViewForRecord(Model $ownerRecord, string $pageClass): bool
    {
        $ownerRecord->load('item');

        return empty($ownerRecord->item);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Tables\Columns\TextColumn::make('order')
                    ->label('Order'),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->reorderable('order')
            ->columns([
                Tables\Columns\TextColumn::make('name'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                //Tables\Actions\EditAction::make(),
                //Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
