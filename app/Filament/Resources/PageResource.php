<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Models\ActionType;
use App\Models\Page;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->striped()
            ->deferLoading()
            ->filtersTriggerAction(function ($action) {
                return $action->button()->label('Filters');
            })
            ->modifyQueryUsing(function (Builder $query) {
                $query
                    ->with(['item']);
            })
            ->paginationPageOptions([25, 50, 100, 200])
            ->persistFiltersInSession()
            ->recordUrl(
                fn (Model $record): string => route('admin.dashboard.page', ['item' => $record->item, 'page' => $record]),
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->formatStateUsing(function ($record) {
                        return 'Page '.$record->order;
                    })
                    ->searchable(['name', 'transcript']),
                Tables\Columns\TextColumn::make('item.name')
                    ->url(fn (Model $record): string => route('admin.dashboard.document', ['item' => $record->item]))
                    ->color('primary'),
                Tables\Columns\TextColumn::make('actions.type.name')
                    ->formatStateUsing(function ($record) {
                        return $record->actions->sortBy('order_column')->pluck('type.name')->join('|');
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('document_type')
                    ->relationship('parent.type', 'name')
                    ->multiple()
                    ->preload(),
                Tables\Filters\Filter::make('not_started')
                    ->form([
                        Select::make('tasks_not_started')
                            ->options(
                                ActionType::query()
                                    ->whereIn('type', ['Documents', 'Publish'])
                                    ->ordered()
                                    ->pluck('name', 'id')
                            )
                            ->multiple()
                            ->preload(),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['tasks_not_started'],
                                function (Builder $query, $tasks) {
                                    $query->where(function (Builder $query) use ($tasks) {
                                        $query->whereDoesntHave('actions', function (Builder $query) use ($tasks) {
                                            $query->whereIn('action_type_id', $tasks);
                                        })
                                            ->orWhereHas('actions', function (Builder $query) use ($tasks) {
                                                $query->whereIn('action_type_id', $tasks)
                                                    ->whereNull('assigned_at')
                                                    ->whereNull('completed_at');
                                            });
                                    });
                                }
                            );
                    }),
            ], layout: Tables\Enums\FiltersLayout::AboveContentCollapsible)
            ->actions([
                //Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
