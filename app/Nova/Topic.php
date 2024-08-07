<?php

namespace App\Nova;

use App\Nova\Actions\ExportSubjects;
use App\Nova\Actions\ImportBiographies;
use App\Nova\Actions\ImportSubjects;
use App\Nova\Filters\SubjectType;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Topic extends Resource
{
    public static $displayInNavigation = false;

    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query
            ->whereRelation('category', 'name', 'Index')
            ->orderBy('name');
    }

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Subject::class;

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
            Text::make(__('Name'), 'name')->sortable(),
            Text::make(__('Slug'), 'slug')->hideWhenCreating()->sortable(),
            BelongsToMany::make('Category'),
            BelongsTo::make('Parent Subject', 'parent', self::class)
                ->nullable()
                ->searchable(),
            HasMany::make('Subjects', 'children', self::class),
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
            new SubjectType,
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
            new ImportSubjects,
            new ImportBiographies,
            (new ExportSubjects)
                ->askForWriterType(),
        ];
    }
}
