<?php

namespace App\Livewire;

use App\Exports\RelationshipExport;
use App\Models\Relationship;
use App\Models\Subject;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\Enums\IconPosition;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\HeaderActionsPosition;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;
use Livewire\Attributes\On;
use Livewire\Attributes\Renderless;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class RelativeFinderFrontend extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public ?Collection $people;

    public bool $process = true;

    public function table(Table $table): Table
    {
        return $table
            //->header(view('components.relative-finder-progress'))
            ->query(
                Relationship::query()
                    ->with([
                        'person',
                        //'person.pages.media',
                    ])
                    ->has('person')
                    ->where(
                        'user_id',
                        auth()->id()
                    )
                    ->where('distance', '!=', 0)
            )
//            ->recordUrl(
//                fn (Model $record): string => route('subjects.show', ['subject' => $record->person->slug])
//            )
            ->striped()
            ->filtersTriggerAction(function ($action) {
                return $action->button()->label('Filters');
            })
            ->paginationPageOptions([25, 50, 100, 200])
            ->persistFiltersInSession()
            ->poll('40s')
            ->defaultSort('distance', 'asc')
            ->emptyStateHeading('No relationships found yet')
            ->emptyStateDescription('Once the process has started, this page will refresh automatically.')
            ->columns([
                ImageColumn::make('person.portrait')
                    ->label('')
                    ->size(32)
                    ->extraImgAttributes(function (Model $record) {
                        return ['data-gender' => $record->person->gender];
                    })
                    ->defaultImageUrl(fn (Model $record): string => url(config('services.familysearch.base_uri').'/platform/tree/persons/'.$record->person->pid.'/portrait?default=https://wilfordwoodruffpapers.org/img/familysearch/'.$record->person->gender.'.png&access_token='.auth()->user()->familysearch_token))
                    ->circular()
                    ->url(fn (Model $record): string => route('subjects.show', ['subject' => $record->person->slug]))
                    ->openUrlInNewTab(),
                TextColumn::make('person.name')
                    ->label(new HtmlString('Name <span class="font-normal">(Click to view documents)</span>'))
                    ->description('')
                    ->size(TextColumn\TextColumnSize::Large)
                    ->formatStateUsing(fn (string $state): string => '<span class="text-secondary font-semibold">'.$state.'</span>')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->iconPosition(IconPosition::After)
                    ->html()
                    ->description(fn (Model $record): string => 'Mentioned in '.$record->person->tagged_count.' '.str('page')->plural($record->person->tagged_count), position: 'below')
                    ->url(fn (Model $record): string => route('subjects.show', ['subject' => $record->person->slug]))
                    ->openUrlInNewTab()
                    ->sortable()
                    ->searchable(),
                //                TextColumn::make('description')
                //                    ->label('Relationship')
                //                    ->size(TextColumn\TextColumnSize::Large)
                //                    ->url(fn (Model $record): string => route('subjects.show', ['subject' => $record->person->slug]))
                //                    ->openUrlInNewTab(),
                TextColumn::make('distance')
                    ->label(new HtmlString('Relationship <span class="font-normal">(distance)</span>'))
                    ->size(TextColumn\TextColumnSize::Large)
                    ->formatStateUsing(fn ($record): string => $record->description.' ('.($record->distance - 1).')')
                    ->url(fn (Model $record): string => route('subjects.show', ['subject' => $record->person->slug]))
                    ->openUrlInNewTab()
                    ->sortable(),
                TextColumn::make('person.public_categories.name')
                    ->label('Category')
                    ->size(TextColumn\TextColumnSize::Large)
                    ->separator(',')
                    ->url(fn (Model $record): string => route('subjects.show', ['subject' => $record->person->slug]))
                    ->openUrlInNewTab(),
                ViewColumn::make('person.pid')
                    ->label('FamilySearch')
                    ->view('components.familysearch-logo'),
            ])
            ->filters([
                SelectFilter::make('category')
                    ->relationship('person.public_categories', 'name')
                    ->preload(),
            ])
            ->headerActions([
                Action::make('download-export')
                    ->label('Export')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->button()
                    ->extraAttributes([
                        'class' => 'bg-secondary text-white hover:bg-secondary-600 rounded-none',
                    ])
                    ->action(function () {
                        return Excel::download(
                            new RelationshipExport,
                            'my-wilford-woodruff-papers-relationships.xlsx',
                            \Maatwebsite\Excel\Excel::XLSX
                        );
                    }),
                Action::make('delete')
                    ->label('Delete Relationships')
                    ->icon('heroicon-o-trash')
                    ->button()
                    ->color('danger')
                    ->extraAttributes([
                        'class' => 'bg-red-500 text-white hover:bg-red-600 rounded-none',
                    ])
                    ->requiresConfirmation()
                    ->action(function () {
                        Relationship::query()
                            ->where('user_id', auth()->id())
                            ->delete();
                        $this->dispatch('stop-processing');
                    }),
            ], position: HeaderActionsPosition::Bottom);
    }

    public function mount()
    {
        $user = auth()->user();
        if (empty($user->familysearch_token)
            || empty($user->familysearch_token_expiration)
            || $user->familysearch_token_expiration < now()) {
            $this->redirect(route('login.familysearch'));
        }
        $this->getPeople();
        //        Artisan::call('relationships:check', [
        //            'id' => $user->id,
        //            'isBatch' => false,
        //        ]);
    }

    public function render(): View
    {
        return view('livewire.relative-finder-frontend')
            ->layout('layouts.guest');
    }

    #[On('update-queue')]
    public function updateQueue()
    {
        $this->getPeople();
        $this->dispatch('update-progress');
    }

    #[On('stop-processing')]
    public function stopQueue()
    {
        $this->process = false;
        $this->dispatch('update-progress');
    }

    private function getPeople()
    {
        if (! $this->process) {
            return;
        }
        $people = Subject::query()
            ->select('id', 'pid')
            ->whereNotNull('pid')
            ->where('pid', '!=', 'n/a')
            ->whereHas('category', function ($query) {
                $query->whereIn('name', ['People'])
                    ->whereNotIn('name', ['Scriptural Figures', 'Historical Figures', 'Eminent Men and Women']);
            })
            ->whereNotIn('id',
                Relationship::query()
                    ->select('subject_id')
                    ->where('user_id', auth()->id())
                    ->pluck('subject_id')
                    ->all()
            )
            ->limit(50)
            ->toBase()
            ->get();

        if ($people->count() > 0) {
            $this->people = $people;
        }
    }

    #[Renderless]
    #[On('new-relationship')]
    public function processRelationship($data, $url)
    {
        $person = Subject::query()->where('pid', str($url)->afterLast('/'))->first();

        if (empty($person)) {
            return;
        }

        if (! empty($data)) {
            //$person = Subject::find($personId);
            $persons = collect(data_get($data, 'persons'));
            $length = $persons->count();
            $relative = $persons->pop();
            $relation = data_get($relative, 'display.relationshipDescription');
            $relationship = Relationship::updateOrCreate([
                'subject_id' => $person->id,
                'user_id' => auth()->id(),
            ],
                [
                    'distance' => $length,
                    'description' => str($relation)->after('My '),
                ]);
        } else {
            $relationship = Relationship::updateOrCreate([
                'subject_id' => $person->id,
                'user_id' => auth()->id(),
            ],
                [
                    'distance' => 0,
                ]);
        }
    }

    #[Renderless]
    #[On('new-relationships')]
    public function processRelationships($data)
    {
        if (! $this->process) {
            return;
        }
        $data = collect($data);

        //        $people = Subject::query()
        //            ->whereIn('id', $data->pluck('pid')->all())
        //            ->get();
        $updates = [];
        foreach ($data as $person) {
            if (! empty($person['data'])) {
                //$person = Subject::find($personId);
                $persons = collect(data_get($person['data'], 'persons'));
                $length = $persons->count();
                $relative = $persons->pop();
                $relation = data_get($relative, 'display.relationshipDescription');
                $updates[] = [
                    'subject_id' => $person['id'],
                    'user_id' => auth()->id(),
                    'distance' => $length,
                    'description' => str($relation)->after('My '),
                ];
            } else {
                $updates[] = [
                    'subject_id' => $person['id'],
                    'user_id' => auth()->id(),
                    'distance' => 0,
                    'description' => null,
                ];
            }
        }
        Relationship::upsert($updates, ['subject_id', 'user_id'], ['distance', 'description']);
    }
}
