<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AssignedTaskResource\Pages;
use App\Models\Action;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AssignedTaskResource extends Resource
{
    protected static ?string $modelLabel = 'Assigned Task';

    protected static ?string $model = Action::class;

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
            ->columns([
                Tables\Columns\TextColumn::make('actionable.name'),
            ])
            ->filters([
                //
            ])
            ->actions([
                //Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->modifyQueryUsing(function (Builder $query) {
                $query
                    ->where('assigned_to', auth()->id())
                    ->whereNull('completed_at')
                    ->where('actionable_type', 'App\Models\Item');
            });
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
            'index' => Pages\ListAssignedTasks::route('/'),
            'create' => Pages\CreateAssignedTask::route('/create'),
            'edit' => Pages\EditAssignedTask::route('/{record}/edit'),
            'view' => Pages\ViewAssignedTask::route('/{record}'),
        ];
    }
}
