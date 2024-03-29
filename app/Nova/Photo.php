<?php

namespace App\Nova;

use DmitryBubyakin\NovaMedialibraryField\Fields\Medialibrary;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphToMany;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Spatie\TagsField\Tags;

class Photo extends Resource
{
    public static $group = 'Website';

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Photo::class;

    public static $with = [
        'media',
        'tags',
    ];

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'title',
        'description',
    ];

    public static function usesScout(): bool
    {
        return false;
    }

    /**
     * Get the fields displayed by the resource.
     */
    public function fields(NovaRequest $request): array
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),
            Text::make(__('Title'), 'title')
                ->required(true)
                ->sortable(),
            Text::make(__('Date'), 'date')
                ->sortable()
                ->placeholder('Ex. 1898-09-08, 1890s, 1907'),
            Text::make(__('Description'), 'description')
                ->hideFromIndex(),
            Medialibrary::make('Image', 'default')
                ->previewUsing('thumb'),
            Text::make('View')->displayUsing(fn () => '<a href="'.($this?->id ? route('media.photos.show', ['photo' => $this->uuid]) : '#').'" class="no-underline dim text-primary font-bold" target="_preview">View</a>')
                ->asHtml()
                ->onlyOnIndex(),
            Text::make(__('Artist or Photographer'), 'artist_or_photographer')
                ->hideFromIndex(),
            Text::make(__('Location'), 'location'),
            Text::make(__('Journal Reference'), 'journal_reference')
                ->hideFromIndex(),
            Text::make(__('Identification'), 'identification')
                ->hideFromIndex(),
            Text::make(__('Source'), 'source')
                ->hideFromIndex(),
            Text::make(__('Notes'), 'notes')
                ->hideFromIndex(),
            Tags::make('Category', 'tags')
                ->type('photos')
                ->withMeta(['placeholder' => 'Add categories...'])
                ->help('Type a category and hit \'Enter\' to add it. Existing tags will appear below the box as you type and can be clicked to add.'),
            MorphToMany::make(__('Events')),
        ];
    }

    /**
     * Get the cards available for the request.
     */
    public function cards(Request $request): array
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     */
    public function filters(Request $request): array
    {
        return [
            new Filters\PhotoCategory,
        ];
    }

    /**
     * Get the lenses available for the resource.
     */
    public function lenses(Request $request): array
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     */
    public function actions(Request $request): array
    {
        return [
            new Actions\ExportPhotos,
        ];
    }
}
