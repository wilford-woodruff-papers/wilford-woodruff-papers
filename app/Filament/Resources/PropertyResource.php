<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PropertyResource\Pages;
use App\Models\Property;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PropertyResource extends Resource
{
    protected static ?string $model = Property::class;

    protected static ?string $navigationGroup = 'Metadata';

    protected static ?string $navigationIcon = 'heroicon-o-hashtag';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Property Details')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->autofocus()
                            ->unique(ignoreRecord: true),
                        Select::make('type')
                            ->label('Property Type')
                            ->options([
                                'date' => 'Date',
                                'html' => 'Html',
                                'link' => 'Link',
                                'text' => 'Text',
                            ])
                            ->required(),
                        Toggle::make('multivalue')
                            ->default(false),
                        RichEditor::make('comment'),
                    ]),
                Section::make('Templates')
                    ->schema([
                        CheckboxList::make('templates')
                            ->relationship('templates', 'name')
                            ->columns(2),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->striped()
            ->paginated([10, 25, 50, 100, 'all'])
            ->defaultPaginationPageOption(50)
            ->filtersTriggerAction(function ($action) {
                return $action->button()->label('Filters');
            })
            ->defaultSort('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Template Name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('template_id')
                    ->label('Template')
                    ->relationship('templates', 'name'),
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'date' => 'Date',
                        'html' => 'Html',
                        'link' => 'Link',
                        'text' => 'Text',
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
            'index' => Pages\ListProperties::route('/'),
            'create' => Pages\CreateProperty::route('/create'),
            'edit' => Pages\EditProperty::route('/{record}/edit'),
        ];
    }
}
