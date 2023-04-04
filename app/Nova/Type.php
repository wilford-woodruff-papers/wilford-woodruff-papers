<?php

namespace App\Nova;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use JeffersonSimaoGoncalves\NovaPermission\Nova\Fields\RoleBooleanGroup;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Type extends Resource
{
    public static $group = 'Metadata';

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Type::class;

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
    ];

    /**
     * Build an "index" query for the given resource.
     */
    public static function indexQuery(NovaRequest $request, $query): Builder
    {
        return $query->orderBy('name');
    }

    /**
     * Get the fields displayed by the resource.
     */
    public function fields(NovaRequest $request): array
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),
            Text::make(__('Name'), 'name')->sortable(),
            RoleBooleanGroup::make('Roles'),
            HasMany::make('Items'),
            BelongsTo::make('Type')->nullable(),
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
