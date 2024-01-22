<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DocumentResource\Pages;
use App\Models\Item;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
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

    protected static ?string $navigationIcon = 'heroicon-o-document';

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Document Information')
                    ->columns(2)
                    ->schema([
                        Select::make('type_id')
                            ->relationship(name: 'type', titleAttribute: 'name')
                            ->preload()
                            ->required(),
                        TextInput::make('name')
                            ->columnSpan(2)
                            ->autofocus()
                            ->required(),
                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->deferLoading()
            ->striped()
//            ->modifyQueryUsing(function (Builder $query) {
//                $query->with(['type']);
//            })
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
                Tables\Columns\TextColumn::make('manual_page_count')
                    ->label('Estimated # Pages'),
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
                Tables\Filters\SelectFilter::make('type')
                    ->relationship('type', 'name'),
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
