<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PhotoResource\Pages;
use App\Models\Photo;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\SpatieTagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Tags\Tag;

class PhotoResource extends Resource
{
    protected static ?string $model = Photo::class;

    protected static ?string $navigationGroup = 'Website';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Section::make()
                    ->schema([
                        TextInput::make('title')
                            ->label('Title')
                            ->required(),
                        TextInput::make('date')
                            ->label('Date')
                            ->placeholder('Ex. 1898-09-08, 1890s, 1907'),
                        TextInput::make('description')
                            ->label('Description'),
                        SpatieMediaLibraryFileUpload::make('image')
                            ->label('Image')
                            ->collection('default'),
                        TextInput::make('artist_or_photographer')
                            ->label('Artist or Photographer'),
                        TextInput::make('location')
                            ->label('Location'),
                        TextInput::make('journal_reference')
                            ->label('Journal Reference'),
                        TextInput::make('identification')
                            ->label('Identification'),
                        TextInput::make('source')
                            ->label('Source'),
                        TextInput::make('notes')
                            ->label('Notes'),
                        SpatieTagsInput::make('tags')
                            ->label('Categories')
                            ->type('photos'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\SpatieMediaLibraryImageColumn::make('avatar'),
                Tables\Columns\TextColumn::make('title')
                    ->label('Title')
                    ->wrap()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date')
                    ->label('Date'),
                Tables\Columns\TextColumn::make('location')
                    ->label('Location')
                    ->wrap(),
                Tables\Columns\TextColumn::make('tags.name')
                    ->label('Tags')
                    ->wrap(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('tags')
                    ->label('Tags')
                    ->multiple()
                    ->options(Tag::getWithType('photos')->pluck('name', 'name'))
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when($data['values'], function (Builder $query, $data): Builder {
                            return $query->withAnyTags(array_values($data), 'photos');
                        });
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('View')
                    ->icon('heroicon-o-eye')
                    ->url(fn (Photo $record) => route('media.photos.show', $record))
                    ->openUrlInNewTab(),
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
            'index' => Pages\ListPhotos::route('/'),
            'create' => Pages\CreatePhoto::route('/create'),
            'edit' => Pages\EditPhoto::route('/{record}/edit'),
        ];
    }
}
