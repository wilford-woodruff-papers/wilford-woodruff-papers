<?php

namespace App\Nova;

use App\Nova\Actions\ImportPhotos;
use App\Nova\Actions\ImportSubjects;
use DmitryBubyakin\NovaMedialibraryField\Fields\Medialibrary;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\HasMany;
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

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
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
            Medialibrary::make('Image', 'default'),
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
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [

        ];
    }
}
