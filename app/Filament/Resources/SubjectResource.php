<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubjectResource\Pages;
use App\Models\Subject;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Tapp\FilamentAuditing\RelationManagers\AuditsRelationManager;

class SubjectResource extends Resource
{
    protected static ?string $navigationGroup = 'Subjects';

    protected static ?string $model = Subject::class;

    protected static ?string $navigationLabel = 'All';

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
            ->filtersTriggerAction(function ($action) {
                return $action->button()->label('Filters');
            })
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Name'),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Categories'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->relationship('category', 'name'),
                Tables\Filters\QueryBuilder::make()
                    ->constraints([
                        Tables\Filters\QueryBuilder\Constraints\TextConstraint::make('name'),
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
            AuditsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSubjects::route('/'),
            'create' => Pages\CreateSubject::route('/create'),
            'edit' => Pages\EditSubject::route('/{record}/edit'),
        ];
    }
}
