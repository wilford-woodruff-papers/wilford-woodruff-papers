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
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;
use Livewire\Component;

class RelativeFinder extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->header(view('components.relative-finder-progress'))
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
            //->heading('Relationships')
            ->striped()
            ->filtersTriggerAction(function ($action) {
                return $action->button()->label('Filters');
            })
            ->paginationPageOptions([25, 50, 100, 200])
            ->persistFiltersInSession()
            ->poll('10s')
            ->defaultSort('distance', 'asc')
            ->emptyStateHeading('No relationships found yet')
            ->emptyStateDescription('Once the process has started, this page will refresh automatically. We will also send an email when it is done.')
            ->columns([
                ImageColumn::make('person.portrait')
                    ->label('')
                    ->size(28)
                    ->extraImgAttributes(function (Model $record) {
                        return ['data-gender' => $record->person->gender];
                    })
                    ->defaultImageUrl(fn (Model $record): string => url(config('services.familysearch.base_uri').'/platform/tree/persons/'.$record->person->pid.'/portrait?default=https://wilfordwoodruffpapers.org/img/familysearch/'.$record->person->gender.'.png&access_token='.auth()->user()->familysearch_token))
                    ->circular(),
                TextColumn::make('person.name')
                    ->label('Name')
                    ->formatStateUsing(fn (string $state): string => '<span class="text-secondary font-semibold">'.$state.'</span>')
                    ->html()
                    ->description(fn (Model $record): string => 'Mentioned in '.$record->person->tagged_count.' pages', position: 'below')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('description')
                    ->label('Relationship'),
                TextColumn::make('distance')
                    ->label('Distance')
                    ->sortable(),
                TextColumn::make('person.public_categories.name')
                    ->label('Category')
                    ->separator(','),
                ViewColumn::make('person.pid')
                    ->label('FamilySearch')
                    ->view('components.familysearch-button'),
            ])
            ->filters([
                SelectFilter::make('category')
                    ->relationship('person.public_categories', 'name')
                    ->preload(),
            ]);
    }

    public function mount()
    {
        $user = auth()->user();
        if (empty($user->familysearch_token)
            || empty($user->familysearch_token_expiration)
            || $user->familysearch_token_expiration < now()) {
            $this->redirect(route('login.familysearch'));
        }
        Artisan::call('relationships:check', [
            'id' => $user->id,
            'isBatch' => false,
        ]);
    }

    public function render(): View
    {
        return view('livewire.relative-finder')
            ->layout('layouts.guest');
    }
}
