<?php

namespace App\Livewire;

use App\Models\Relationship;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class RelativeFinder extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Relationship::query()
                    ->with([
                        'person',
                    ])
                    ->where(
                        'user_id',
                        auth()->id()
                    )
                    ->where('distance', '!=', 0)
            )
            ->recordUrl(
                fn (Model $record): string => route('subjects.show', ['subject' => $record->person->slug]),
            )
            ->poll('10s')
            ->defaultSort('distance', 'asc')
            ->columns([
                ImageColumn::make('avatar')
                    ->label('Image')

                    ->defaultImageUrl(fn (Model $record): string => url(config('services.familysearch.base_uri').'/platform/tree/persons/'.$record->person->pid.'/portrait?default=/images/placeholder.png&access_token='.auth()->user()->familysearch_token))
                    ->circular(),
                TextColumn::make('person.name')
                    ->label('Name')
                    ->description(fn (Model $record): string => 'Mentioned in '.$record->person->tagged_count.' pages', position: 'below')
                    ->sortable(),
                TextColumn::make('description')
                    ->label('Relationship'),
                TextColumn::make('distance')
                    ->label('Distance')
                    ->sortable(),
                ViewColumn::make('familysearch')
                    ->label('FamilySearch Link')
                    ->view('components.familysearch-button'),
            ]);
    }

    public function render(): View
    {
        return view('livewire.relative-finder')
            ->layout('layouts.guest');
    }
}
