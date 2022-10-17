<?php

namespace App\Nova;

use App\Nova\Actions\ExportSubjects;
use App\Nova\Actions\ExportSubjectsWithChildren;
use App\Nova\Actions\ImportBiographies;
use App\Nova\Actions\ImportIndexTopics;
use App\Nova\Actions\ImportSubjects;
use App\Nova\Actions\ParseNames;
use App\Nova\Filters\Index;
use App\Nova\Filters\SubjectType;
use Emilianotisato\NovaTinyMCE\NovaTinyMCE;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;

class Subject extends Resource
{
    public static $group = 'Metadata';

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

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),
            Text::make(__('Name'), 'name')->sortable(),
            Text::make(__('Slug'), 'slug')
                ->hideFromIndex()
                ->hideWhenCreating()
                ->sortable(),
            NovaTinyMCE::make('Bio')->alwaysShow(),
            NovaTinyMCE::make('Footnotes')->alwaysShow(),
            BelongsToMany::make('Category'),
            BelongsTo::make('Parent Subject', 'parent', self::class)
                ->nullable()
                ->searchable(),
            HasMany::make('Subjects', 'children', self::class),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [
            new SubjectType,
            new Index,
        ];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [
            new ImportIndexTopics,
            new ImportSubjects,
            new ImportBiographies,
            (new ExportSubjects)
                ->askForWriterType(),
            (new ExportSubjectsWithChildren)
                ->askForWriterType(),
            new ParseNames,
        ];
    }
}
