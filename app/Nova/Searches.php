<?php

namespace App\Nova;

use App\Nova\Actions\ExportSearches;
use App\Nova\Filters\CreatedAfterFilter;
use App\Nova\Filters\CreatedBeforeFilter;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Code;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Spatie\Activitylog\Models\Activity;

//use PosLifestyle\DateRangeFilter\DateRangeFilter;

class Searches extends Resource
{
    public static $group = 'Website';

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = Activity::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'description';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->where('event', 'search');
    }

    public static function uriKey()
    {
        return 'user-searches';
    }

    /**
     * Get the fields displayed by the resource.
     */
    public function fields(NovaRequest $request): array
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),
            Text::make('Search Term', 'description')->sortable(),
            DateTime::make('Date', 'created_at')->sortable(),
            Code::make('Properties')
                ->json(),
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
            new CreatedAfterFilter,
            new CreatedBeforeFilter,
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
            new ExportSearches,
        ];
    }
}
