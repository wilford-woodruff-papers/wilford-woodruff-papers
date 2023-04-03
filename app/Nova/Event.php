<?php

namespace App\Nova;

use App\Nova\Actions\ExportTimeline;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphToMany;
use Laravel\Nova\Fields\Number;
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

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(Request $request): array
    {
        return [
            ID::make(__('ID'), 'id'),
            Text::make(__('Description'), 'text')
                ->displayUsing(function ($value) {
                    return str($value)->limit(40, '...');
                }),
            Number::make('Start Year'),
            Number::make('Start Month'),
            Number::make('Start Day'),
            Number::make('End Year'),
            Number::make('End Month'),
            Number::make('End Day'),
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
     *
     * @return array
     */
    public function cards(Request $request): array
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array
     */
    public function filters(Request $request): array
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @return array
     */
    public function lenses(Request $request): array
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @return array
     */
    public function actions(Request $request): array
    {
        return [
            new ExportTimeline,
        ];
    }
}
