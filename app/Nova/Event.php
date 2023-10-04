<?php

namespace App\Nova;

use App\Nova\Actions\ExportTimeline;
use App\Nova\Actions\ImportTimeline;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphToMany;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Event extends Resource
{
    public static $group = 'Website';

    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->orderBy('start_year')
            ->orderBy('start_month')
            ->orderBy('start_day')
            ->orderBy('end_year')
            ->orderBy('end_month')
            ->orderBy('end_day');
    }

    public static function label()
    {
        return 'Timeline';
    }

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Event::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'text';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'text',
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
            ID::make(__('ID'), 'id'),
            Text::make('Display Date')
                ->help('Only enter a display date if and exact date is unknown. Ex. Spring 1820 instead of April 12, 1820')
                ->nullable(),
            Date::make('Start At')
                ->help('The start date is used for sorting purposes. The display date will be displayed instead when provided.')
                ->required(),
            Date::make('End At'),
            Text::make(__('Description'), 'text')
                ->displayUsing(function ($value) {
                    return str($value)->limit(40, '...');
                }),
            BelongsToMany::make('Places', 'places', Place::class)
                ->searchable(),

            /*Number::make('Start Year'),
            Number::make('Start Month'),
            Number::make('Start Day'),
            Number::make('End Year'),
            Number::make('End Month'),
            Number::make('End Day'),*/

            MorphToMany::make('Photos'),
            MorphToMany::make('Pages')->searchable(),

            /*->fields(function(){
                    return [
                        Item::class,
                        Photo::class,
                    ];
            })->nullable(),*/
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
        return [
            new ExportTimeline,
            new ImportTimeline,
        ];
    }
}
