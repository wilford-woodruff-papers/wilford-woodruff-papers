<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DocumentResource\Pages;
use App\Models\CopyrightStatus;
use App\Models\Item;
use App\Models\Property;
use App\Models\Repository;
use App\Models\Source;
use App\Models\Template;
use App\Models\Type;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class DocumentResource extends Resource
{
    protected static ?string $model = Item::class;

    protected static ?string $modelLabel = 'Document';

    protected static ?string $recordRouteKeyName = 'uuid';

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make([
                    'default' => 1,
                    'md' => 3,
                ])
                    ->schema([
                        Section::make('Document Metadata')
                            ->visible(function (?Model $record, Get $get) {
                                return ! empty($record) && ! empty($get('type_id'));
                            })
                            ->columnSpan(function (?Model $record) {
                                return ! empty($record) ? 2 : 3;
                            })
                            ->columns(1)
                            ->schema(function (?Model $record, Get $get) {
                                if (empty($record)) {
                                    return [];
                                }

                                return [
                                    TextInput::make('name')
                                        ->visible(function (?Model $record, Get $get) {
                                            return ! empty($record);
                                        })
                                        ->columnSpan(1)
                                        ->autofocus()
                                        ->required(),
                                    ...Template::query()
                                        ->with([
                                            'properties' => fn ($query) => $query->where('enabled', true),
                                        ])
                                        ->where('type_id', $get('type_id'))
                                        ->first()
                                        ->properties
                                        ->map(function ($property) {
                                            $field = match ($property->type) {
                                                'text', 'link' => TextInput::make('values.'.$property->id)
                                                    ->label($property->name)
                                                    ->formatStateUsing(function (?Model $record) use ($property) {
                                                        return $record->values->firstWhere('property_id', $property->id)?->value;
                                                    })
                                                    ->required($property->required)
                                                    ->columnSpan(1),
                                                'html' => RichEditor::make('values.'.$property->id)
                                                    ->label($property->name)
                                                    ->formatStateUsing(function (?Model $record) use ($property) {
                                                        return $record->values->firstWhere('property_id', $property->id)?->value;
                                                    })
                                                    ->required($property->required)
                                                    ->columnSpan(1),
                                                'date' => TextInput::make('values.'.$property->id)
                                                    ->label($property->name)
                                                    ->date()
                                                    ->formatStateUsing(function (?Model $record) use ($property) {
                                                        return $record->values->firstWhere('property_id', $property->id)?->value;
                                                    })
                                                    ->required($property->required)
                                                    ->columnSpan(1),
                                                'relationship' => Select::make('values.'.$property->id)
                                                    ->label($property->name)
                                                    ->live()
                                                    ->options(function (?Model $record, Get $get) use ($property) {
                                                        $record->loadMissing(['values.property']);
                                                        //dd($get('values.'.$record->values->firstWhere('property_id', Property::firstWhere('name', '*Source')->id)?->value));
                                                        // dd(Property::firstWhere('name', '*Source')->id);

                                                        return match ($property->relationship) {
                                                            'Source' => Source::query()->pluck('name', 'id')->toArray(),
                                                            'Repository' => Repository::query()
                                                                ->where(
                                                                    'source_id',
                                                                    $get('values.'.Property::firstWhere('name', '*Source')->id)
                                                                )
                                                                ->pluck('name', 'id')
                                                                ->toArray(),
                                                            'CopyrightStatus' => CopyrightStatus::query()->pluck('name', 'id')->toArray(),
                                                            default => [],
                                                        };
                                                    })
                                                    ->formatStateUsing(function (?Model $record) use ($property) {
                                                        return $record->values->firstWhere('property_id', $property->id)?->value;
                                                    })
                                                    ->createOptionForm(function (Get $get) use ($property) {
                                                        return match ($property->relationship) {
                                                            'Source' => [
                                                                TextInput::make('name')
                                                                    ->required(),
                                                            ],
                                                            'Repository' => [
                                                                TextInput::make('name')
                                                                    ->required(),
                                                            ],
                                                        };
                                                    })
                                                    ->createOptionUsing(function (array $data) use ($property) {
                                                        return match ($property->relationship) {
                                                            'Source' => Source::create($data)->id,
                                                            'Repository' => function (Get $get) use ($data) {
                                                                $data['source_id'] = $get('values.'.Property::firstWhere('name', '*Source')->id);

                                                                return Repository::create($data)->id;
                                                            },
                                                        };
                                                    })
                                                    ->searchable()
                                                    ->required($property->required)
                                                    ->columnSpan(1),
                                                default => TextInput::make('values.'.$property->id)
                                                    ->label($property->name)
                                                    ->required($property->required)
                                                    ->columnSpan(1),
                                            };
                                            if ($property->nullable) {
                                                return Fieldset::make()
                                                    ->columns(4)
                                                    ->schema([
                                                        $field->visible(function (Get $get) use ($property) {
                                                            return ! $get('not_found.'.$property->id);
                                                        })
                                                            ->columnSpan(3),
                                                        Checkbox::make('not_found.'.$property->id)
                                                            ->label('Not Available')
                                                            ->live()
                                                            ->columnSpan(1),
                                                    ]);
                                            } else {
                                                return $field;
                                            }
                                        })
                                        ->toArray(),
                                ];
                                //return [];
                            }),
                        Section::make('Document Information')
                            ->columnSpan(function (?Model $record) {
                                return ! empty($record) ? 1 : 3;
                            })
                            ->columns(2)
                            ->schema([
                                TextInput::make('name')
                                    ->visible(function (?Model $record, Get $get) {
                                        return empty($record);
                                    })
                                    ->columnSpan(2)
                                    ->autofocus()
                                    ->required(),
                                TextInput::make('pcf_unique_id_full')
                                    ->label('Unique ID')
                                    ->formatStateUsing(function (?Model $record) {
                                        return $record?->pcf_unique_id_full;
                                    })
                                    ->visible(function (?Model $record, Get $get) {
                                        return ! empty($record);
                                    })
                                    ->columnSpan(2)
                                    ->disabled(),
                                Select::make('type_id')
                                    ->relationship(name: 'type', titleAttribute: 'name', modifyQueryUsing: fn (Builder $query) => $query->whereNull('type_id'))
                                    ->live()
                                    ->disabled(function (?Model $record) {
                                        return ! empty($record);
                                    })
                                    ->preload()
                                    ->required()
                                    ->columnSpan(1),
                                TextInput::make('manual_page_count')
                                    ->label('Page Count (Manual)')
                                    ->integer()
                                    ->visible(function (?Model $record, Get $get) {
                                        return empty($record->auto_page_count) || $record->auto_page_count === 0;
                                    })
                                    ->columnSpan(1),
                                TextInput::make('auto_page_count')
                                    ->label('Page Count (Auto)')
                                    ->integer()
                                    ->visible(function (?Model $record, Get $get) {
                                        return ! empty($record->auto_page_count) && $record->auto_page_count > 0;
                                    })
                                    ->columnSpan(1),
                                TextInput::make('section_count')
                                    ->integer()
                                    ->default(0)
                                    ->helperText('Only add sections if the document has been split up into multiple sections. Usually if a document is under 20 pages this field will not be used.')
                                    ->visible(function (?Model $record, Get $get) {
                                        return empty($record) && Type::query()
                                            ->whereHas('subType')
                                            ->where('id', $get('type_id'))
                                            ->count() > 0;
                                    })
                                    ->columnSpan(1),
                            ]),
                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->deferLoading()
            ->striped()
            ->modifyQueryUsing(function (Builder $query) {
                $query
                    ->with(['values'])
                    ->withCount(['publishing_tasks'])
                    ->whereNotNull('type_id');
            })
            ->filtersTriggerAction(function ($action) {
                return $action->button()->label('Filters');
            })
            ->paginationPageOptions([25, 50, 100, 200])
            ->persistFiltersInSession()
            ->persistSearchInSession()
            ->persistColumnSearchesInSession()
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->formatStateUsing(function (int $state, Model $record) {
                        return $record->pcf_unique_id_prefix.'-'.$record->pcf_unique_id.$record->pcf_unique_id_suffix;
                    })
                    ->searchable(),
                Tables\Columns\IconColumn::make('enabled')
                    ->label('Published')
                    ->icon(fn (string $state): string => match ($state) {
                        '1' => 'heroicon-o-check-circle',
                        '0' => 'heroicon-o-x-circle',
                        default => '',
                    })
                    ->color(fn (string $state): string => match ($state) {
                        '1' => 'success',
                        '0' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(isIndividual: true),
                Tables\Columns\TextColumn::make('type.name'),
                Tables\Columns\TextColumn::make('auto_page_count')
                    ->label('Actual # Pages'),
                Tables\Columns\TextColumn::make('publishing_tasks_count')
                    ->label('Publishing Tasks Completed')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('enabled')
                    ->label('Published Status')
                    ->placeholder('All')
                    ->trueLabel('Published')
                    ->falseLabel('Not Published')
                    ->queries(
                        true: fn (Builder $query) => $query->where('enabled', 1),
                        false: fn (Builder $query) => $query->where('enabled', 0),
                        blank: fn (Builder $query) => $query,
                    ),
                Tables\Filters\TernaryFilter::make('imported')
                    ->label('Imported Status')
                    ->placeholder('All')
                    ->trueLabel('Imported')
                    ->falseLabel('Not Imported')
                    ->queries(
                        true: fn (Builder $query) => $query
                            ->where(function (Builder $query) {
                                $query
                                    ->where('auto_page_count', '>', 0)
                                    ->orWhereHas('items');
                            })
                            ->whereNull('item_id'),
                        false: fn (Builder $query) => $query
                            ->where('auto_page_count', '=', 0)
                            ->where('enabled', false),
                        blank: fn (Builder $query) => $query,
                    ),
                Tables\Filters\Filter::make('types')
                    ->form([
                        Select::make('type')
                            ->options(Type::query()->whereNull('type_id')->pluck('name', 'id')->all()),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['type'],
                                function (Builder $query, $type): Builder {
                                    return $query->whereHas('type', function (Builder $query) use ($type) {
                                        $query->whereIn(
                                            'id',
                                            collect([
                                                intval($type),
                                                Type::query()->where('type_id', $type)->first()?->id,
                                            ])->filter()->toArray());
                                    });
                                }
                            );
                    }),
                Tables\Filters\QueryBuilder::make()
                    ->constraints([
                        Tables\Filters\QueryBuilder\Constraints\TextConstraint::make('name'),
                        Tables\Filters\QueryBuilder\Constraints\TextConstraint::make('values.value'),
                    ]),
            ], layout: Tables\Enums\FiltersLayout::AboveContentCollapsible)
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([

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
            'index' => Pages\ListDocuments::route('/'),
            'create' => Pages\CreateDocument::route('/create'),
            'edit' => Pages\EditDocument::route('/{record}/edit'),
        ];
    }
}
