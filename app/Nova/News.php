<?php

namespace App\Nova;

use App\Nova\Metrics\CreatedPerMonth;
use Emilianotisato\NovaTinyMCE\NovaTinyMCE;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class News extends Resource
{
    public static $group = 'Media';

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\News::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'title',
        'subtitle',
        'description',
        'transcript',
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
            Image::make(__('Cover Image'), 'cover_image')
                ->disk('media')
                ->help('A cover image is required to display articles on the homepage'),
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
            Text::make(__('Author Name(s)'), 'subtitle')
                ->displayUsing(function ($subtitle) {
                    return Str::of($subtitle)->limit('50', ' ...');
                })
                ->sortable(),
            Text::make(__('Publisher Name'), 'publisher')
                ->sortable()
                ->required(true)
                ->help('Examples: Meridian Magazine, Work + Wonder, The LDS Women Project, Digital Journal, Deseret News, Y Magazine. Used for link when linking to external site.'),
            Text::make('Link')
                ->hideFromIndex(),
            Boolean::make('Open in New Window?', 'external_link_only'),
            NovaTinyMCE::make('Summary', 'description')
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
            new CreatedPerMonth(\App\Models\News::class),
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
