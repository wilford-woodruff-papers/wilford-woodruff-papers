<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TaskReportingResource\Pages;
use App\Models\Action;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TaskReportingResource extends Resource
{
    protected static ?string $model = Action::class;

    protected static ?string $modelLabel = 'Task Reporting';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
            ->filtersTriggerAction(function ($action) {
                return $action->button()->label('Filters');
            })
            ->paginationPageOptions([25, 50, 100, 200])
            ->persistFiltersInSession()
            ->groups([
                Tables\Grouping\Group::make('assignee.name')
                    ->label('Assignee Name'),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('type.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('actionable.item.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('actionable.order')
                    ->formatStateUsing(fn (Action $record) => 'Page '.$record->actionable->order)
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('assignee.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('assigned_at')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('completed_at')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('assignee')
                    ->relationship('assignee', 'name', fn (Builder $query) => $query->has('roles'))
                    ->preload(),
                Tables\Filters\SelectFilter::make('type')
                    ->relationship('type', 'name', fn (Builder $query) => $query->where('type', 'Documents'))
                    ->preload(),
            ])
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
            'index' => Pages\ListTaskReportings::route('/'),
            'create' => Pages\CreateTaskReporting::route('/create'),
            'edit' => Pages\EditTaskReporting::route('/{record}/edit'),
        ];
    }
}
