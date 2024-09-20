<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FigureResource\Pages;
use App\Models\Figure;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class FigureResource extends Resource
{
    protected static ?string $model = Figure::class;

    protected static ?string $navigationIcon = 'heroicon-o-heart';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Figure Information')
                    ->columns(1)
                    ->schema([
                        FileUpload::make('filename')
                            ->label('Symbol Image')
                            ->disk('figures')
                            ->image()
                            ->required(),
                        TextInput::make('tracking_number')
                            ->label('Tracking #')
                            ->numeric()
                            ->default(function () {
                                return Figure::count() + 1;
                            })
                            ->required(),
                        TextInput::make('design_description')
                            ->label('Symbol Description')
                            ->required(),
                        TextInput::make('period_usage')
                            ->label('Time of Use'),
                        TextInput::make('quantitative_utilization')
                            ->label('Quantitative Utilization'),
                        TextInput::make('qualitative_utilization')
                            ->label('Qualitative Utilization'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultPaginationPageOption(50)
            ->columns([
                Tables\Columns\ImageColumn::make('filename')
                    ->disk('figures')
                    ->label('Symbol Image'),
                Tables\Columns\TextColumn::make('tracking_number')
                    ->label('Tracking #'),
                Tables\Columns\TextColumn::make('design_description')
                    ->label('Symbol Description')
                    ->wrap(),
                Tables\Columns\TextColumn::make('period_usage')
                    ->label('Time of Use')
                    ->wrap(),
                Tables\Columns\TextColumn::make('quantitative_utilization')
                    ->label('Quantitative Utilization')
                    ->wrap(),
                Tables\Columns\TextColumn::make('qualitative_utilization')
                    ->label('Qualitative Utilization')
                    ->wrap(),
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
            'index' => Pages\ListFigures::route('/'),
            'create' => Pages\CreateFigure::route('/create'),
            'edit' => Pages\EditFigure::route('/{record}/edit'),
        ];
    }
}
