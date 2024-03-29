<?php

namespace App\Nova;

use App\Nova\Actions\ExportPeople;
use App\Nova\Actions\ExportSubjects;
use App\Nova\Actions\ExportSubjectsWithChildren;
use App\Nova\Actions\ImportGeolocation;
use App\Nova\Actions\ImportIndexTopics;
use App\Nova\Actions\ImportPeople;
use App\Nova\Actions\ImportSubjects;
use App\Nova\Actions\ParseNames;
use App\Nova\Filters\ParentSubjects;
use App\Nova\Filters\SubjectIsTagged;
use App\Nova\Filters\SubjectType;
use Emilianotisato\NovaTinyMCE\NovaTinyMCE;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Subject extends Resource
{
    public static $group = 'Metadata';

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Subject::class;

    public static $with = [
        'parent',
        'category',
    ];

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
            ID::make(__('ID'), 'id')
                ->sortable(),
            Text::make(__('Name'), 'name')
                ->sortable(),
            Number::make(__('Total'), 'total_usage_count')
                ->readonly()
                ->sortable(),
            Number::make(__('Tagged'), 'tagged_count')
                ->readonly()
                ->sortable(),
            Text::make('Category', function () {
                return $this->category->pluck('name')->implode(', ');
            })
                ->onlyOnIndex(),
            Text::make(__('Slug'), 'slug')
                ->hideFromIndex()
                ->hideWhenCreating()
                ->sortable(),
            NovaTinyMCE::make('Bio')
                ->asHtml()
                ->alwaysShow(),
            NovaTinyMCE::make('Footnotes')
                ->asHtml()
                ->alwaysShow(),
            BelongsToMany::make('Category'),
            BelongsTo::make('Parent Subject', 'parent', self::class)
                ->nullable()
                ->searchable(),
            HasMany::make('Subjects', 'children', self::class),
            BelongsToMany::make('Events'),
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
            new SubjectIsTagged,
            new ParentSubjects,
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
            new ImportIndexTopics,
            new ImportSubjects,
            new ImportPeople,
            //new ImportBiographies,
            new ImportGeolocation,
            (new ExportSubjects)
                ->askForWriterType(),
            (new ExportPeople)
                ->askForWriterType(),
            (new ExportSubjectsWithChildren)
                ->askForWriterType(),
            new ParseNames,
        ];
    }
}
