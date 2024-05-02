<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ComeFollowMeResource\Pages;
use App\Models\ComeFollowMe;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ComeFollowMeResource extends Resource
{
    protected static ?string $model = ComeFollowMe::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $label = 'Come Follow Me';

    protected static ?string $pluralLabel = 'Come Follow Me';

    protected static ?string $pluralModelLabel = 'Come Follow Me';

    protected static ?string $navigationLabel = 'Come Follow Me';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->columns(2)
                    ->schema([
                        Select::make('book')
                            ->options([
                                'Book of Mormon' => 'Book of Mormon',
                                'Doctrine & Covenants' => 'Doctrine & Covenants',
                                'New Testament' => 'New Testament',
                                'Old Testament' => 'Old Testament',
                            ])
                            ->required(),
                        Select::make('week')
                            ->options(range(1, 53))
                            ->required(),
                        TextInput::make('date')
                            ->required(),
                        TextInput::make('reference')
                            ->required(),
                        TextInput::make('title')
                            ->required(),
                        SpatieMediaLibraryFileUpload::make('cover_image')
                            ->columnSpan(2)
                            ->disk('come_follow_me')
                            ->multiple(false)
                            ->required(),
                        Textarea::make('quote')
                            ->columnSpan(2)
                            ->required(),
                        Select::make('page_id')
                            ->label('Quote Page')
                            ->relationship(name: 'page', titleAttribute: 'full_name')
                            ->searchable(['full_name'])
                            ->nullable()
                            ->columnSpan(2)
                            ->required(),
                    ]),
                Section::make()
                    ->columns(1)
                    ->schema([
                        Repeater::make('events')
                            ->columns(2)
                            ->schema([
                                TextInput::make('description')
                                    ->required(),
                                Select::make('page_id')
                                    ->label('Page')
                                    ->relationship(name: 'page', titleAttribute: 'full_name')
                                    ->searchable(['full_name'])
                                    ->required(),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('book')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('week')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('reference')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('book')
                    ->options([
                        'Book of Mormon' => 'Book of Mormon',
                        'Doctrine & Covenants' => 'Doctrine & Covenants',
                        'New Testament' => 'New Testament',
                        'Old Testament' => 'Old Testament',
                    ]),
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
            'index' => Pages\ListComeFollowMes::route('/'),
            'create' => Pages\CreateComeFollowMe::route('/create'),
            'edit' => Pages\EditComeFollowMe::route('/{record}/edit'),
        ];
    }
}
