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
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

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
                        Toggle::make('enabled')
                            ->label('Enabled')
                            ->default(false),
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
                                'relationship' => 'Relationship',
                            ])
                            ->live()
                            ->required(),
                        Select::make('relationship')
                            ->label('Relationship')
                            ->options([
                                'Source' => 'Source',
                                'Repository' => 'Repository',
                                'CopyrightStatus' => 'Copyright Status',
                            ])
                            ->visible(fn (Get $get): bool => $get('type') === 'relationship')
                            ->required(),
                        Toggle::make('required')
                            ->default(false),
                        Toggle::make('nullable')
                            ->default(false),
                        Toggle::make('multivalue')
                            ->default(false),
                        Toggle::make('readonly')
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
                Tables\Columns\ToggleColumn::make('enabled')
                    ->label('Enabled')
                    ->sortable(),
                Tables\Columns\ToggleColumn::make('required')
                    ->label('Required')
                    ->sortable(),
                Tables\Columns\ToggleColumn::make('nullable')
                    ->label('Nullable')
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Template Name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('enabled')
                    ->nullable()
                    ->queries(
                        true: fn (Builder $query) => $query->where('enabled', true),
                        false: fn (Builder $query) => $query->where('enabled', false),
                        blank: fn (Builder $query) => $query, // In this example, we do not want to filter the query when it is blank.
                    ),
                Tables\Filters\SelectFilter::make('template_id')
                    ->label('Template')
                    ->relationship('templates', 'name'),
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'date' => 'Date',
                        'html' => 'Html',
                        'link' => 'Link',
                        'text' => 'Text',
                        'relationship' => 'Relationship',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //Tables\Actions\DeleteBulkAction::make(),
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
