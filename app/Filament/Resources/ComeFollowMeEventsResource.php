<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ComeFollowMeEventsResource\Pages;
use App\Models\ComeFollowMeEvent;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ComeFollowMeEventsResource extends Resource
{
    protected static ?string $model = ComeFollowMeEvent::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                //
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
            'index' => Pages\ListComeFollowMeEvents::route('/'),
            'create' => Pages\CreateComeFollowMeEvents::route('/create'),
            'edit' => Pages\EditComeFollowMeEvents::route('/{record}/edit'),
        ];
    }
}
