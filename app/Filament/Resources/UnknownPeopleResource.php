<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UnknownPeopleResource\Pages;
use App\Models\PeopleIdentification;
use App\Models\User;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class UnknownPeopleResource extends Resource
{
    protected static ?string $model = PeopleIdentification::class;

    protected static ?string $navigationGroup = 'Subjects';

    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';

    public static function form(Form $form): Form
    {
        return $form
            ->columns([
                'sm' => 3,
                'xl' => 6,
                '2xl' => 8,
            ])
            ->schema([
                Section::make('Person')
                    ->columnSpan([
                        'sm' => 2,
                        'xl' => 4,
                        '2xl' => 6,
                    ])
                    ->columns(4)
                    ->schema([
                        TextInput::make('link_to_ftp')
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
                        Fieldset::make('Names & Dates')
                            ->schema([
                                TextInput::make('title')
                                    ->label('Title'),
                                TextInput::make('first_middle_name')
                                    ->label('First & Middle Name or Initials'),
                                TextInput::make('last_name')
                                    ->label('Surname Name or Initial'),
                                TextInput::make('other')
                                    ->label('Other Names'),
                                TextInput::make('approximate_birth_date')
                                    ->label('Approx Birth'),
                                TextInput::make('approximate_death_date')
                                    ->label('Approx Death'),
                                TextInput::make('fs_id')
                                    ->label('FS ID'),
                            ]),
                        Fieldset::make('Research')
                            ->schema([
                                RichEditor::make('guesses')
                                    ->label('Guesses or Notes (if any)')
                                    ->columnSpan(4),
                                RichEditor::make('notes')
                                    ->label('Notes')
                                    ->columnSpan(4),
                            ]),
                        Fieldset::make('Links')
                            ->schema(function () {
                                return collect([
                                    'nauvoo_database',
                                    'pioneer_database',
                                    'missionary_database',
                                    'boston_index',
                                    'st_louis_index',
                                    'british_mission',
                                    'eighteen_forty_census',
                                    'eighteen_fifty_census',
                                    'eighteen_sixty_census',
                                    'other_census',
                                    'other_records',
                                ])
                                    ->map(function ($link) {
                                        return TextInput::make($link)
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
                                            );
                                    })
                                    ->toArray();
                            }),
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
                                        Cache::remember('bio-editors-and-admins', 3600, function () {
                                            return User::query()
                                                ->role(['Bio Editor', 'Bio Admin'])
                                                ->orderBy('name')
                                                ->pluck('name', 'id')
                                                ->all();
                                        })
                                    )
                                    ->searchable(),
                                TextInput::make('editorial_assistant')
                                    ->label('Editorial Assistant'),
                                Toggle::make('correction_needed')
                                    ->onColor('warning')
                                    ->inline(),
                                Toggle::make('cant_be_identified')
                                    ->onColor('warning')
                                    ->inline(),
                                Toggle::make('skip_tagging')
                                    ->onColor('warning')
                                    ->inline(),
                                DatePicker::make('completed_at')
                                    ->label('Completed At')
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
                            ]),
                        Section::make('Additional (Read Only)')
                            ->visible(fn ($record) => ! empty($record))
                            ->schema([
                                TextInput::make('id')
                                    ->label('Unique ID')
                                    ->readOnly(),
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
            ->filtersTriggerAction(function ($action) {
                return $action->button()->label('Filters');
            })
            ->paginationPageOptions([25, 50, 100, 200])
            ->persistFiltersInSession()
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
                    ->falseIcon('heroicon-o-check-circle')
                    ->trueIcon('heroicon-o-x-circle')
                    ->falseColor('success')
                    ->trueColor('danger')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->date('D, d M Y H:i:s')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('Researcher')
                    ->options(
                        Cache::remember('bio-editors-and-admins', 3600, function () {
                            return User::query()
                                ->role(['Bio Editor', 'Bio Admin'])
                                ->orderBy('name')
                                ->pluck('name', 'id')
                                ->all();
                        })
                    )
                    ->searchable()
                    ->attribute('researcher_id'),
                Tables\Filters\TernaryFilter::make('completed_at')
                    ->label('Completed')
                    ->placeholder('All')
                    ->trueLabel('Completed')
                    ->falseLabel('Not Completed')
                    ->queries(
                        true: fn (Builder $query) => $query->whereNotNull('completed_at'),
                        false: fn (Builder $query) => $query->whereNull('completed_at'),
                        blank: fn (Builder $query) => $query,
                    ),
                Tables\Filters\TernaryFilter::make('correction_needed')
                    ->label('Correction Needed')
                    ->placeholder('All')
                    ->trueLabel('Yes')
                    ->falseLabel('No')
                    ->queries(
                        true: fn (Builder $query) => $query->whereNotNull('correction_needed'),
                        false: fn (Builder $query) => $query->whereNull('correction_needed'),
                        blank: fn (Builder $query) => $query,
                    ),
                Tables\Filters\TernaryFilter::make('cant_be_identified')
                    ->label('Identifiable')
                    ->placeholder('All')
                    ->trueLabel('Yes')
                    ->falseLabel('No')
                    ->queries(
                        true: fn (Builder $query) => $query->where('cant_be_identified', 0),
                        false: fn (Builder $query) => $query->where('cant_be_identified', 1),
                        blank: fn (Builder $query) => $query,
                    ),
                Tables\Filters\QueryBuilder::make()
                    ->constraints([
                        Tables\Filters\QueryBuilder\Constraints\TextConstraint::make('first_middle_name'),
                        Tables\Filters\QueryBuilder\Constraints\TextConstraint::make('last_name'),
                        Tables\Filters\QueryBuilder\Constraints\TextConstraint::make('title'),
                        Tables\Filters\QueryBuilder\Constraints\TextConstraint::make('guesses'),
                        Tables\Filters\QueryBuilder\Constraints\TextConstraint::make('notes'),
                        Tables\Filters\QueryBuilder\Constraints\TextConstraint::make('location'),
                        Tables\Filters\QueryBuilder\Constraints\DateConstraint::make('approximate_birth_date'),
                        Tables\Filters\QueryBuilder\Constraints\DateConstraint::make('approximate_death_date'),
                        Tables\Filters\QueryBuilder\Constraints\DateConstraint::make('updated_at'),
                    ]),
            ], layout: Tables\Enums\FiltersLayout::AboveContentCollapsible)
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
