<?php

namespace App\Filament\Resources;

use App\Filament\Actions\Tables\Subjects\ClaimSubject;
use App\Filament\Actions\Tables\UpdateSubjectValue;
use App\Filament\Resources\PeopleResource\Pages;
use App\Livewire\PeopleDuplicateChecker;
use App\Models\Item;
use App\Models\Subject;
use App\Models\User;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Livewire;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Select as SelectFilter;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Pages\Page;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Tapp\FilamentAuditing\RelationManagers\AuditsRelationManager;

class PeopleResource extends Resource
{
    protected static ?string $model = Subject::class;

    protected static ?string $navigationGroup = 'Subjects';

    protected static ?string $modelLabel = 'Person';

    protected static ?string $navigationLabel = 'People';

    protected static ?string $breadcrumb = 'People';

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

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
                    ->columns(3)
                    ->schema([
                        Livewire::make(PeopleDuplicateChecker::class, ['person' => $form->getRecord()])
                            ->columnSpan(3),
                        TextInput::make('name')
                            ->label('Full Name (As used in FTP)')
                            ->required()
                            ->autofocus(fn () => empty($form->getRecord()))
                            ->columnSpan(3),
                        Select::make('gender')
                            ->label('M/F')
                            ->columnSpan(1)
                            ->options([
                                'F' => 'Female',
                                'M' => 'Male',
                                'U' => 'Unknown',
                            ])
                            ->required(),
                        TextInput::make('pid')
                            ->label('PID')
                            ->columnSpan(2)
                            ->hintAction(
                                Action::make('not-available')
                                    ->label(function ($state) {
                                        return empty($state) ? 'n/a' : 'Clear';
                                    })
                                    ->action(function (Set $set, $state) {
                                        if (empty($state)) {
                                            $set('pid', 'n/a');
                                        } else {
                                            $set('pid', '');
                                        }
                                    })
                            )
                            ->suffixAction(
                                Action::make('open-familysearch-url')
                                    ->icon('heroicon-o-arrow-top-right-on-square')
                                    ->visible(function ($state) {
                                        return ! empty($state);
                                    })
                                    ->url(function (Model $record) {
                                        return $record->pid !== 'n/a'
                                            ? 'https://www.familysearch.org/tree/person/details/'.$record->pid
                                            : null;
                                    }, true)
                            ),
                        TextInput::make('subject_uri')
                            ->label('Full FTP URL')
                            ->required()
                            ->columnSpan(2)
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
                        DatePicker::make('added_to_ftp_at')
                            ->label('Added to FTP')
                            ->required()
                            ->columnSpan(1)
                            ->hintAction(
                                Action::make('now')
                                    ->label(function ($state) {
                                        return empty($state) ? 'Now' : 'Clear';
                                    })
                                    ->action(function (Set $set, $state) {
                                        if (empty($state)) {
                                            $set('added_to_ftp_at', now()->toDateString());
                                        } else {
                                            $set('added_to_ftp_at', null);
                                        }
                                    })
                            ),
                        TextInput::make('reference')
                            ->label('Reference')
                            ->columnSpan(3),
                        TextInput::make('relationship')
                            ->label('Relationship to Wilford Woodruff')
                            ->columnSpan(3),
                        Fieldset::make('Names')
                            ->schema([
                                TextInput::make('first_name')
                                    ->label('Given Name'),
                                TextInput::make('middle_name')
                                    ->label('Middle Name'),
                                TextInput::make('last_name')
                                    ->label('Surname'),
                                TextInput::make('suffix')
                                    ->label('Suffix'),
                                TextInput::make('alternate_names')
                                    ->label('Alternate Names'),
                                TextInput::make('maiden_name')
                                    ->label('Maiden Name'),
                            ]),
                        Fieldset::make('Dates')
                            ->schema([
                                DatePicker::make('birth_date')
                                    ->label('Birth Date'),
                                DatePicker::make('baptism_date')
                                    ->label('Baptism Date'),
                                DatePicker::make('death_date')
                                    ->label('Death Date'),
                                TextInput::make('life_years')
                                    ->label('Birth - Death'),
                            ]),
                        Fieldset::make('Special Categories')
                            ->schema([
                                CheckboxList::make('category')
                                    ->columnSpan(3)
                                    ->label('Categories')
                                    ->relationship(
                                        name: 'category',
                                        titleAttribute: 'name',
                                        modifyQueryUsing: fn (Builder $query) => $query->whereRelation('parent', 'name', '=', 'People'),
                                    )
                                    ->columns(4)
                                    ->gridDirection('row'),
                                Select::make('subcategory')
                                    ->label('Subcategory')
                                    ->options(
                                        Cache::remember('subcategory', 3600, function () {
                                            return Subject::query()
                                                ->select(DB::raw('DISTINCT(subcategory)'))
                                                ->whereHas('category', function (Builder $query) {
                                                    $query->whereIn('categories.name', ['People']);
                                                })
                                                ->whereNotNull('subcategory')
                                                ->orderBy('subcategory')
                                                ->pluck('subcategory')
                                                ->all();
                                        })
                                    ),
                            ]),
                        Fieldset::make('Research')
                            ->schema([
                                RichEditor::make('bio')
                                    ->label('Biography')
                                    ->columnSpan(2),
                                TextInput::make('short_bio')
                                    ->label('Short Biography')
                                    ->columnSpan(2),
                                RichEditor::make('footnotes')
                                    ->label('Footnotes')
                                    ->columnSpan(2),
                                RichEditor::make('notes')
                                    ->label('Notes')
                                    ->columnSpan(2),
                                TextInput::make('log_link')
                                    ->label('Log Link')
                                    ->columnSpan(2),
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
                                        Cache::remember('bio-editors-and-admins', 3600, function () {
                                            return User::query()
                                                ->role(['Bio Editor', 'Bio Admin'])
                                                ->orderBy('name')
                                                ->pluck('name', 'id')
                                                ->all();
                                        })
                                    )
                                    ->searchable(),
                                Toggle::make('incomplete_identification')
                                    ->onColor('warning')
                                    ->inline(),
                                DatePicker::make('bio_completed_at')
                                    ->label('Biography Completed On')
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
                                    ->label('Biography Approved On')
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
                                DatePicker::make('short_bio_completed_at')
                                    ->label('Short Biography Completed On')
                                    ->hintAction(
                                        Action::make('now')
                                            ->label(function ($state) {
                                                return empty($state) ? 'Now' : 'Clear';
                                            })
                                            ->action(function (Set $set, $state) {
                                                if (empty($state)) {
                                                    $set('short_bio_completed_at', now()->toDateString());
                                                } else {
                                                    $set('short_bio_completed_at', null);
                                                }
                                            })
                                    ),

                                DatePicker::make('confirmed_name_at')
                                    ->label('Name Confirmed On')
                                    ->readOnly(function () {
                                        return auth()->user()->hasRole('Bio Admin');
                                    })
                                    ->hintAction(function () {
                                        if (! auth()->user()->hasRole('Bio Admin')) {
                                            return null;
                                        }

                                        return Action::make('now')
                                            ->label(function ($state) {
                                                return empty($state) ? 'Now' : 'Clear';
                                            })
                                            ->action(function (Set $set, $state) {
                                                if (empty($state)) {
                                                    $set('confirmed_name_at', now()->toDateString());
                                                } else {
                                                    $set('confirmed_name_at', null);
                                                }
                                            });
                                    }

                                    ),

                                DatePicker::make('approved_for_print_at')
                                    ->label('Approved For Print On')
                                    ->readOnly(function () {
                                        return auth()->user()->hasRole('Bio Admin');
                                    })
                                    ->hintAction(function () {
                                        if (! auth()->user()->hasRole('Bio Admin')) {
                                            return null;
                                        }

                                        return Action::make('now')
                                            ->label(function ($state) {
                                                return empty($state) ? 'Now' : 'Clear';
                                            })
                                            ->action(function (Set $set, $state) {
                                                if (empty($state)) {
                                                    $set('approved_for_print_at', now()->toDateString());
                                                } else {
                                                    $set('approved_for_print_at', null);
                                                }
                                            });
                                    }),
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
                                TextInput::make('unique_id')
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
            ->modifyQueryUsing(function (Builder $query) {
                $query->people()
                    ->with([
                        'category',
                        'researcher',
                    ]);
            })
            ->groups([
                Tables\Grouping\Group::make('researcher.name')
                    ->label('Researcher'),
            ])
            ->filtersTriggerAction(function ($action) {
                return $action->button()->label('Filters');
            })
            ->paginationPageOptions([25, 50, 100, 200])
            ->persistFiltersInSession()
            ->persistSearchInSession()
            ->persistColumnSearchesInSession()
            ->columns([
                Tables\Columns\TextColumn::make('unique_id')
                    ->label('ID')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
//                    ->formatStateUsing(function (Model $record, string $state): string {
//                        return match (trim($record->subcategory)) {
//                            'New England' => '<span class="bg-orange-100">'.$state.'</span>',
//                            default => $state
//                        };
//                    })
//                    ->html()
                    ->searchable(isIndividual: true)
                    ->sortable(),
                Tables\Columns\SelectColumn::make('gender')
                    ->label('-- Gender (M/F) --')
                    ->width('100px')
                    ->options([
                        'F' => 'Female',
                        'M' => 'Male',
                        'U' => 'Unknown',
                    ]),
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
                Tables\Columns\TextColumn::make('birth_date')
                    ->label('Birth')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('death_date')
                    ->label('Death')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('life_years')
                    ->label('B-D')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('pid')
                    ->label('PID/FSID')
                    ->url(function (Model $record) {
                        return $record->pid !== 'n/a'
                            ? 'https://www.familysearch.org/tree/person/details/'.$record->pid
                            : null;
                    }, true)
                    ->color(function (Model $record) {
                        return $record->pid !== 'n/a'
                            ? 'primary'
                            : null;
                    })
                    ->searchable(isIndividual: true)
                    ->toggleable(),
                Tables\Columns\IconColumn::make('incomplete_identification')
                    ->label('II')
                    ->icon(function (string $state): string {
                        switch ($state) {
                            case 1: return 'heroicon-o-exclamation-triangle';
                            default: return '';
                        }
                    })
                    ->color('warning')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('added_to_ftp_at')
                    ->label('Added to FTP')
                    ->date()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('given_name')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('middle_name')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('last_name')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('suffix')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('alternate_names')
                    ->label('Alternate')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('maiden_name')
                    ->label('Maiden')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('baptism_date')
                    ->label('Baptism')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Special Categories')
                    ->state(function ($record) {
                        return $record
                            ->category
                            ->reject(fn ($category) => $category->name === 'People')
                            ->pluck('name')
                            ->join('<br/>');
                    })
                    ->html()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('reference')
                    ->limit(50)
                    ->toggleable(),
                Tables\Columns\TextColumn::make('relationship')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('researcher.name')
                    ->state(function (Model $record) {
                        return $record->researcher_id !== null
                            ? $record->researcher->name
                            : $record->researcher_text;
                    })
                    ->toggleable(),
                Tables\Columns\TextColumn::make('bio_completed_at')
                    ->date()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('bio_approved_at')
                    ->date()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('short_bio_completed_at')
                    ->date()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('bio')
                    ->state(function (Model $record) {
                        return trim(strip_tags($record->bio));
                    })
                    ->limit(50)
                    ->toggleable(),
                Tables\Columns\TextColumn::make('short_bio')
                    ->state(function (Model $record) {
                        return trim(strip_tags($record->short_bio));
                    })
                    ->limit(50)
                    ->toggleable(),
                Tables\Columns\TextColumn::make('footnotes')
                    ->state(function (Model $record) {
                        return trim(strip_tags($record->footnotes));
                    })
                    ->limit(50)
                    ->toggleable(),
                Tables\Columns\TextColumn::make('notes')
                    ->state(function (Model $record) {
                        return trim(strip_tags($record->notes));
                    })
                    ->limit(50)
                    ->toggleable(),
                Tables\Columns\TextColumn::make('subcategory')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('confirmed_name_at')
                    ->date()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('approved_for_print_at')
                    ->date()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->date()
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
                Tables\Filters\SelectFilter::make('category')
                    ->relationship('category', 'name', fn (Builder $query) => $query->whereRelation('parent', 'name', '=', 'People')),
                Tables\Filters\TernaryFilter::make('incomplete_identification')
                    ->label('II')
                    ->placeholder('All')
                    ->trueLabel('Incomplete')
                    ->falseLabel('Not Incomplete')
                    ->queries(
                        true: fn (Builder $query) => $query->where('incomplete_identification', 1),
                        false: fn (Builder $query) => $query->where('incomplete_identification', 0),
                        blank: fn (Builder $query) => $query,
                    ),
                Tables\Filters\TernaryFilter::make('tagged')
                    ->label('Status')
                    ->placeholder('All')
                    ->trueLabel('Tagged')
                    ->falseLabel('Not Tagged')
                    ->queries(
                        true: fn (Builder $query) => $query->where('tagged_count', '>', 0),
                        false: fn (Builder $query) => $query->where('tagged_count', '<', 1),
                        blank: fn (Builder $query) => $query,
                    ),
                Tables\Filters\TernaryFilter::make('bio_completed')
                    ->label('Bio Completed')
                    ->placeholder('All')
                    ->trueLabel('Completed')
                    ->falseLabel('Not Completed')
                    ->queries(
                        true: fn (Builder $query) => $query->whereNotNull('bio_completed_at'),
                        false: fn (Builder $query) => $query->whereNull('bio_completed_at'),
                        blank: fn (Builder $query) => $query,
                    ),
                Tables\Filters\TernaryFilter::make('bio_approved')
                    ->label('Bio Approved')
                    ->placeholder('All')
                    ->trueLabel('Approved')
                    ->falseLabel('Not Approved')
                    ->queries(
                        true: fn (Builder $query) => $query->whereNotNull('bio_approved_at'),
                        false: fn (Builder $query) => $query->whereNull('bio_approved_at'),
                        blank: fn (Builder $query) => $query,
                    ),
                Tables\Filters\TernaryFilter::make('short_bio_completed')
                    ->label('Short Bio Completed')
                    ->placeholder('All')
                    ->trueLabel('Completed')
                    ->falseLabel('Not Completed')
                    ->queries(
                        true: fn (Builder $query) => $query->whereNotNull('short_bio_completed_at'),
                        false: fn (Builder $query) => $query->whereNull('short_bio_completed_at'),
                        blank: fn (Builder $query) => $query,
                    ),
                Tables\Filters\TernaryFilter::make('confirmed_name')
                    ->label('Name Confirmed')
                    ->placeholder('All')
                    ->trueLabel('Confirmed')
                    ->falseLabel('Not Confirmed')
                    ->queries(
                        true: fn (Builder $query) => $query->whereNotNull('confirmed_name_at'),
                        false: fn (Builder $query) => $query->whereNull('confirmed_name_at'),
                        blank: fn (Builder $query) => $query,
                    ),
                Tables\Filters\TernaryFilter::make('approved_for_print')
                    ->label('Approved For Print')
                    ->placeholder('All')
                    ->trueLabel('Approved')
                    ->falseLabel('Not Approved')
                    ->queries(
                        true: fn (Builder $query) => $query->whereNotNull('approved_for_print_at'),
                        false: fn (Builder $query) => $query->whereNull('approved_for_print_at'),
                        blank: fn (Builder $query) => $query,
                    ),
                Tables\Filters\TernaryFilter::make('pid')
                    ->label('PID Found')
                    ->placeholder('All')
                    ->trueLabel('Found or n/a')
                    ->falseLabel('Not Found')
                    ->queries(
                        true: fn (Builder $query) => $query->whereNotNull('pid'),
                        false: fn (Builder $query) => $query->whereNull('pid'),
                        blank: fn (Builder $query) => $query,
                    ),
                Tables\Filters\TernaryFilter::make('gender')
                    ->label('M/F')
                    ->placeholder('All')
                    ->trueLabel('Is Set')
                    ->falseLabel('Is Not Set')
                    ->queries(
                        true: fn (Builder $query) => $query->whereNotNull('gender'),
                        false: fn (Builder $query) => $query->whereNull('gender'),
                        blank: fn (Builder $query) => $query,
                    ),
                Tables\Filters\TernaryFilter::make('log_link')
                    ->label('Research Log')
                    ->placeholder('All')
                    ->trueLabel('Is Linked')
                    ->falseLabel('Is Not Linked')
                    ->queries(
                        true: fn (Builder $query) => $query->whereNotNull('log_link'),
                        false: fn (Builder $query) => $query->whereNull('log_link'),
                        blank: fn (Builder $query) => $query,
                    ),
                //                Filter::make('document_type')
                //                    ->form([
                //                        SelectFilter::make('type')
                //                            ->label('In Document Type')
                //                            ->placeholder('All')
                //                            ->options(
                //                                Cache::remember('doc-types-for-people', 3600, function () {
                //                                    return Type::query()
                //                                        ->whereNull('type_id')
                //                                        ->orderBy('name')
                //                                        ->pluck('name', 'id')
                //                                        ->all();
                //                                })
                //                            ),
                //                    ])
                //                    ->query(function (Builder $query, array $data): Builder {
                //                        return $query
                //                            ->when(
                //                                $data['type'],
                //                                function (Builder $query, $type): Builder {
                //                                    $types = Type::query()
                //                                        ->where('id', $type)
                //                                        ->orWhere('type_id', $type)
                //                                        ->pluck('id')
                //                                        ->toArray();
                //
                //                                    return $query->whereRelation('pages.type', function ($query) use ($types) {
                //                                        $query->whereIn('types.id', $types);
                //                                    });
                //                                },
                //                            );
                //                    }),
                Filter::make('journal')
                    ->form([
                        SelectFilter::make('journals')
                            ->label('In Journal')
                            ->placeholder('-- Select --')
                            ->options(
                                Cache::remember('journals-for-people', 3600, function () {
                                    return Item::query()
                                        ->select(['id', 'name'])
                                        ->whereRelation('type', 'name', 'Journals')
                                        ->orderBy('first_date', 'ASC')
                                        ->get()
                                        ->map(function ($item, $key) {
                                            return ['id' => $item->id, 'name' => ($key + 1).' - '.$item->name];
                                        })
                                        ->pluck('name', 'id')
                                        ->all();
                                })
                            ),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when($data['journals'], function (Builder $query, $journal) {
                            return $query->whereRelation('pages.parent', function ($query) use ($journal) {
                                $query->where('items.id', $journal);
                            });
                        });
                    }),
                Filter::make('document_type')
                    ->form([
                        SelectFilter::make('document_types')
                            ->label('In Document Type')
                            ->placeholder('-- Select --')
                            ->options([
                                'Additional' => 'Additional',
                                'Autobiographies' => 'Autobiographies',
                                'Daybooks' => 'Daybooks',
                                'Discourses' => 'Discourses',
                                'Journals' => 'Journals',
                                'Letters' => 'Letters',
                            ]),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        $types = match ($data['document_types']) {
                            'Additional' => ['Additional', 'Additional Sections'],
                            'Autobiographies' => ['Autobiographies', 'Autobiography Sections'],
                            'Daybooks' => ['Daybooks'],
                            'Discourses' => ['Discourses'],
                            'Journals' => ['Journals', 'Journal Sections'],
                            'Letters' => ['Letters'],
                            default => null,
                        };

                        return $query->when($types, function (Builder $query, $types) {
                            return $query->whereRelation('pages.parent.type', function ($query) use ($types) {
                                $query->whereIn('types.name', $types);
                            });
                        });
                    }),
                Tables\Filters\QueryBuilder::make()
                    ->constraints([
                        Tables\Filters\QueryBuilder\Constraints\TextConstraint::make('name'),
                        Tables\Filters\QueryBuilder\Constraints\TextConstraint::make('slug'),
                        Tables\Filters\QueryBuilder\Constraints\TextConstraint::make('first_name'),
                        Tables\Filters\QueryBuilder\Constraints\TextConstraint::make('last_name'),
                        Tables\Filters\QueryBuilder\Constraints\TextConstraint::make('maiden_name'),
                        Tables\Filters\QueryBuilder\Constraints\TextConstraint::make('alternate_names'),
                        Tables\Filters\QueryBuilder\Constraints\TextConstraint::make('bio'),
                        Tables\Filters\QueryBuilder\Constraints\TextConstraint::make('footnotes'),
                        Tables\Filters\QueryBuilder\Constraints\TextConstraint::make('pid'),
                        Tables\Filters\QueryBuilder\Constraints\DateConstraint::make('birth_date'),
                        Tables\Filters\QueryBuilder\Constraints\DateConstraint::make('death_date'),
                        Tables\Filters\QueryBuilder\Constraints\DateConstraint::make('updated_at'),
                        Tables\Filters\QueryBuilder\Constraints\DateConstraint::make('bio_completed_at'),
                        Tables\Filters\QueryBuilder\Constraints\DateConstraint::make('bio_approved_at'),
                    ]),
            ], layout: Tables\Enums\FiltersLayout::AboveContentCollapsible)
            ->actions([
                ClaimSubject::make()
                    ->visible(fn (Model $record) => ($record->researcher_id === null && empty($record->researcher_text))),
                // Tables\Actions\EditAction::make(),
            ], position: Tables\Enums\ActionsPosition::BeforeCells)
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    UpdateSubjectValue::make()
                        ->setModel(Subject::class)
                        ->visible(auth()->user()->hasAnyRole(['Super Admin'])),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            AuditsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPeople::route('/'),
            'create' => Pages\CreatePeople::route('/create'),
            'edit' => Pages\EditPeople::route('/{record}/edit'),
            //'related' => Pages\RelatedPeople::route('/{record}/related'),
        ];
    }

    public static function getRecordSubNavigation(Page $page): array
    {
        return $page->generateNavigationItems([
            //Pages\RelatedPeople::class,
        ]);
    }
}
