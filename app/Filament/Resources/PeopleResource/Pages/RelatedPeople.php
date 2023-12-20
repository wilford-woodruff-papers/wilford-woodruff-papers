<?php

namespace App\Filament\Resources\PeopleResource\Pages;

use App\Filament\Resources\PeopleResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class RelatedPeople extends ListRecords
{
    protected static string $resource = PeopleResource::class;

    protected static string $view = 'filament.resources.people-resource.pages.related-people';

    public function mount(): void
    {
        static::authorizeResourceAccess();
    }

    public function table(Table $table): Table
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
            ->filtersTriggerAction(function ($action) {
                return $action->button()->label('Filters');
            })
            ->paginationPageOptions([25, 50, 100, 200])
            ->persistFiltersInSession()
            ->columns([
                TextColumn::make('unique_id')
                    ->label('ID')
                    ->searchable(),
                TextColumn::make('name')

                    ->searchable()
                    ->sortable(),

            ])
            ->filters([

            ])
            ->actions([

            ])
            ->bulkActions([

            ]);
    }
}
