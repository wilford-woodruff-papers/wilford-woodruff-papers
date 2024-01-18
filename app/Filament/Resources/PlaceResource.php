<?php

namespace App\Filament\Resources;

use App\Filament\Actions\Tables\Subjects\ClaimSubject;
use App\Filament\Resources\PlaceResource\Pages;
use App\Models\Subject;
use App\Models\User;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class PlaceResource extends Resource
{
    protected static ?string $model = Subject::class;

    protected static ?string $navigationGroup = 'Subjects';

    protected static ?string $navigationIcon = 'heroicon-o-map';

    protected static ?string $modelLabel = 'Place';

    protected static ?string $navigationLabel = 'Places';

    protected static ?string $breadcrumb = 'Places';

    public static function form(Form $form): Form
    {
        return $form
            ->columns([
                'sm' => 3,
                'xl' => 6,
                '2xl' => 8,
            ])
            ->schema([
                Section::make('Place')
                    ->columnSpan([
                        'sm' => 2,
                        'xl' => 4,
                        '2xl' => 6,
                    ])
                    ->columns(4)
                    ->schema([
                        TextInput::make('subject_uri')
                            ->label('Full FTP URL')
                            ->required()
                            ->columnSpan(4)
                            ->suffixAction(
                                Action::make('open-url')
                                    ->icon('heroicon-o-arrow-top-right-on-square')
                                    ->visible(function ($state) {
                                        return ! empty($state);
                                    })
                                    ->url(function ($state) {
                                        return ! empty($state)
                                            ? $state
                                            : null;
                                    }, true)
                            ),
                        Fieldset::make('Names')
                            ->schema([
                                TextInput::make('country'),
                                TextInput::make('state_province')
                                    ->label('State/Province'),
                                TextInput::make('county'),
                                TextInput::make('city'),
                                TextInput::make('specific_place'),
                                TextInput::make('modern_location'),
                            ]),
                        Fieldset::make('Meta')
                            ->columns(2)
                            ->schema([
                                TextInput::make('years')
                                    ->columnSpan(2),
                                Grid::make()
                                    ->columns(2)
                                    ->columnSpan(2)
                                    ->schema([
                                        Fieldset::make('Geolocation')
                                            ->columnSpan(1)
                                            ->columns(1)
                                            ->schema([
                                                TextInput::make('latitude'),
                                                TextInput::make('longitude'),
                                            ]),
                                        Fieldset::make('Map')
                                            ->columns(1)
                                            ->columnSpan(1)
                                            ->schema([
                                                ViewField::make('map')
                                                    ->view('filament.forms.components.map'),
                                            ]),
                                    ]),

                            ]),
                        Fieldset::make('Research')
                            ->schema([
                                RichEditor::make('bio')
                                    ->label('Description')
                                    ->columnSpan(4),
                                RichEditor::make('notes')
                                    ->label('Notes')
                                    ->columnSpan(4),
                                TextInput::make('log_link')
                                    ->label('Log Link')
                                    ->columnSpan(4),
                            ]),
                    ]),
                Grid::make()
                    ->columnSpan([
                        'sm' => 1,
                        'xl' => 2,
                        '2xl' => 2,
                    ])
                    ->schema([
                        Section::make('Info')

                            ->schema([
                                Select::make('researcher_id')
                                    ->label('Researcher')
                                    ->options(
                                        Cache::remember('researchers', 3600, function () {
                                            return User::query()
                                                ->role(['Researcher'])
                                                ->orderBy('name')
                                                ->pluck('name', 'id')
                                                ->all();
                                        })
                                    )
                                    ->searchable(),
                                DatePicker::make('place_confirmed_at')
                                    ->label('Date Confirmed')
                                    ->hintAction(
                                        Action::make('now')
                                            ->label(function ($state) {
                                                return empty($state) ? 'Now' : 'Clear';
                                            })
                                            ->action(function (Set $set, $state) {
                                                if (empty($state)) {
                                                    $set('place_confirmed_at', now()->toDateString());
                                                } else {
                                                    $set('place_confirmed_at', null);
                                                }
                                            })
                                    ),
                                DatePicker::make('bio_completed_at')
                                    ->label('Description Completed On')
                                    ->hintAction(
                                        Action::make('now')
                                            ->label(function ($state) {
                                                return empty($state) ? 'Now' : 'Clear';
                                            })
                                            ->action(function (Set $set, $state) {
                                                if (empty($state)) {
                                                    $set('bio_completed_at', now()->toDateString());
                                                } else {
                                                    $set('bio_completed_at', null);
                                                }
                                            })
                                    ),
                                DatePicker::make('bio_approved_at')
                                    ->label('Description Approved On')
                                    ->hintAction(
                                        Action::make('now')
                                            ->label(function ($state) {
                                                return empty($state) ? 'Now' : 'Clear';
                                            })
                                            ->action(function (Set $set, $state) {
                                                if (empty($state)) {
                                                    $set('bio_approved_at', now()->toDateString());
                                                } else {
                                                    $set('bio_approved_at', null);
                                                }
                                            })
                                    ),
                            ]),
                        Section::make('Additional (Read Only)')
                            ->visible(fn ($record) => ! empty($record))
                            ->schema([
                                Actions::make([
                                    Action::make('open-nova-link')
                                        ->label('Nova')
                                        ->icon('heroicon-o-arrow-top-right-on-square')
                                        ->visible(function (Model $record) {
                                            return ! empty($record);
                                        })
                                        ->url(function (Model $record) {
                                            return ! empty($record?->id)
                                                ? '/nova/resources/subjects/'.$record->id
                                                : null;
                                        }, true),
                                    Action::make('open-website-link')
                                        ->label('Website')
                                        ->icon('heroicon-o-arrow-top-right-on-square')
                                        ->visible(function (Model $record) {
                                            return ! empty($record);
                                        })
                                        ->url(function (Model $record) {
                                            return ! empty($record?->slug)
                                                ? route('subjects.show', ['subject' => $record->slug])
                                                : null;
                                        }, true),
                                ])
                                    ->columns(2),
                                TextInput::make('id')
                                    ->label('Internal ID')
                                    ->readOnly(),
                                DatePicker::make('updated_at')
                                    ->readOnly(),
                                DatePicker::make('created_at')
                                    ->readOnly(),
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
                $query->places()
                    ->with([
                        'category',
                        'researcher',
                    ]);
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
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\IconColumn::make('subject_uri')
                    ->label('FTP')
                    ->icon(function (string $state): ?string {
                        return ! empty($state)
                            ? 'heroicon-o-arrow-top-right-on-square'
                            : null;
                    })
                    ->url(function (Model $record) {
                        return ! empty($record->subject_uri)
                            ? $record->subject_uri
                            : null;
                    }, true)
                    ->color('primary')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('tagged_count')
                    ->label('Usage')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('country')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('state_province')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('county')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('city')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('specific_place')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('years')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\IconColumn::make('visited')
                    ->boolean()
                    ->falseIcon('heroicon-o-check-circle')
                    ->trueIcon('heroicon-o-x-circle')
                    ->falseColor('success')
                    ->trueColor('gray')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\IconColumn::make('mentioned')
                    ->boolean()
                    ->falseIcon('heroicon-o-check-circle')
                    ->trueIcon('heroicon-o-x-circle')
                    ->falseColor('success')
                    ->trueColor('gray')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('latitude')
                    ->label('Lat')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('longitude')
                    ->label('Long')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('place_confirmed_at')
                    ->label('Confirmed At')
                    ->date()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('modern_location')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('added_to_ftp_at')
                    ->date()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('reference')
                    ->label('Source')
                    ->state(function (Model $record) {
                        return trim(strip_tags($record->bio));
                    })
                    ->limit(50)
                    ->toggleable(),
                Tables\Columns\TextColumn::make('notes')
                    ->state(function (Model $record) {
                        return trim(strip_tags($record->bio));
                    })
                    ->limit(50)
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('Researcher')
                    ->options(
                        Cache::remember('researchers', 3600, function () {
                            return User::query()
                                ->role(['Researcher'])
                                ->orderBy('name')
                                ->pluck('name', 'id')
                                ->all();
                        })
                    )
                    ->searchable()
                    ->attribute('researcher_id'),
            ], layout: Tables\Enums\FiltersLayout::AboveContentCollapsible)
            ->actions([
                ClaimSubject::make()
                    ->visible(fn (Model $record) => ($record->researcher_id === null && empty($record->researcher_text))),
                // Tables\Actions\EditAction::make(),
            ], position: Tables\Enums\ActionsPosition::BeforeCells)
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
            'index' => Pages\ListPlaces::route('/'),
            'create' => Pages\CreatePlace::route('/create'),
            'edit' => Pages\EditPlace::route('/{record}/edit'),
        ];
    }
}
