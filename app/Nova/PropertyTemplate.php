<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use PixelCreation\NovaFieldSortable\Concerns\SortsIndexEntries;
use PixelCreation\NovaFieldSortable\Sortable;

class PropertyTemplate extends Resource
{
    use SortsIndexEntries;

    public static $group = 'Database';

    public static $defaultSortField = 'order_column';

    public static $with = ['property'];

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\PropertyTemplate::class;

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
    ];

    public static function label()
    {
        return Str::plural(Str::title('Template Property'));
    }

    /**
     * Get the fields displayed by the resource.
     */
    public function fields(NovaRequest $request): array
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),
            Sortable::make('Order', 'order_column')
                ->onlyOnIndex(),
            Text::make('Name', function ($model) {
                return sprintf('%s', $model->property->name);
            })
                ->onlyOnIndex(),
            Text::make('Template', function ($model) {
                return sprintf('%s', $model->template->name);
            })
                ->onlyOnIndex(),
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
            new \App\Nova\Filters\Template(),
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
