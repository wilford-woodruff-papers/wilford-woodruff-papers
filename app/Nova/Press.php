<?php

namespace App\Nova;

use App\Nova\Filters\PressType;
use Emilianotisato\NovaTinyMCE\NovaTinyMCE;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;

class Press extends Resource
{
    public static $displayInNavigation = false;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Press::class;

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
            Select::make(__('Type'))->options([
                'Article' => 'Article',
                'News' => 'News',
                'Podcast' => 'Podcast',
                'Video' => 'Video',
            ])->sortable(),
            Image::make(__('Cover Image'), 'cover_image')->disk('media'),
            Date::make(__('Date'), 'date')->sortable(),
            Text::make(__('Title'), 'title')->sortable(),
            Text::make(__('Slug'), 'slug')->hideFromIndex()->hideWhenCreating()->sortable(),
            Text::make(__('Subtitle'), 'subtitle')->resolveUsing(function ($subtitle) {
                return Str::of($subtitle)->limit('50', ' ...');
            })->sortable(),
            // Text::make(__('Slug'), 'slug')->hideWhenCreating()->sortable(),
            Textarea::make('Excerpt'),
            NovaTinyMCE::make('Description')->options([
                'use_lfm' => true,
                'height' => 500,
            ])
                ->asHtml()
                ->alwaysShow(),
            NovaTinyMCE::make('Transcript')
                ->options([
                    'height' => 500,
                ])
                ->asHtml()
                ->alwaysShow(),
            Text::make('Link')->hideFromIndex(),
            Textarea::make('Embed')->hideFromIndex(),
            HasMany::make('Media'),
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
            new PressType,
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
        return [];
    }
}
