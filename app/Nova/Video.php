<?php

namespace App\Nova;

use App\Nova\Metrics\CreatedPerMonth;
use Emilianotisato\NovaTinyMCE\NovaTinyMCE;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Spatie\TagsField\Tags;

class Video extends Resource
{
    public static $group = 'Media';

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Video::class;

    public static $with = ['tags'];

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
    ];

    /**
     * Get the fields displayed by the resource.
     */
    public function fields(NovaRequest $request): array
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),
            Image::make(__('Cover Image'), 'cover_image')
                ->disk('media')
                ->help('A cover image is required to display videos on the homepage'),
            Text::make(__('Title'), 'title')
                ->required(true)
                ->sortable(),
            Text::make(__('Slug'), 'slug')
                ->hideFromIndex()
                ->hideWhenCreating()
                ->sortable()
                ->help('The slug is automatically generated, but can be updated if needed to make the URL more user friendly. It must be unique.'),
            Date::make(__('Publish At'), 'date')
                ->required(true)
                ->sortable(),
            Text::make('Youtube Link', 'link')
                ->required(true)
                ->hideFromIndex()
                ->help('Paste the YouTube URL in this box (not the embed code).'),
            NovaTinyMCE::make('Credits')
                ->options([
                    'height' => 500,
                ])
                ->asHtml()
                ->alwaysShow(),
            Tags::make('Category', 'tags')
                ->type('videos')
                ->withMeta(['placeholder' => 'Add categories...'])
                ->help('Type a category and hit \'Enter\' to add it. Existing tags will appear below the box as you type and can be clicked to add.'),
            NovaTinyMCE::make('Transcript')
                ->options([
                    'height' => 500,
                ])
                ->asHtml()
                ->alwaysShow(),
            BelongsToMany::make('Authors')->hideFromIndex(),
        ];
    }

    /**
     * Get the cards available for the request.
     */
    public function cards(Request $request): array
    {
        return [
            new CreatedPerMonth(\App\Models\Video::class),
        ];
    }

    /**
     * Get the filters available for the resource.
     */
    public function filters(Request $request): array
    {
        return [];
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
        return [];
    }
}
