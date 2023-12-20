<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Http\Requests\NovaRequest;
use PixelCreation\NovaFieldSortable\Concerns\SortsIndexEntries;
use PixelCreation\NovaFieldSortable\Sortable;

class TeamMember extends Resource
{
    use SortsIndexEntries;

    public static $displayInNavigation = false;

    public static $defaultSortField = 'order';

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\BoardMember::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'name',
        'title',
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
            Sortable::make('Order', 'order')
                ->onlyOnIndex(),
            BelongsTo::make('Team', 'team', Team::class)->nullable(),
            Text::make(__('Name'), 'name')->sortable(),
            Text::make(__('Title'), 'title')->sortable(),
            Trix::make(__('Bio'), 'bio')->alwaysShow(),
            Image::make(__('Picture'), 'image')->disk('board_members'),
            Text::make('Youtube Link', 'video_link')
                ->required(false)
                ->hideFromIndex()
                ->help('Paste the YouTube URL in this box (not the embed code).'),
            Image::make(__('Supporting Image'), 'supporting_image')->disk('board_members'),
            Text::make(__('Supporting Person Name'), 'supporting_person_name')->hideFromIndex(),
            Text::make(__('Supporting Person Description'), 'supporting_image_description')->hideFromIndex(),
            Text::make(__('Supporting Person Link'), 'supporting_person_link')->hideFromIndex(),
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
