<?php

namespace App\Nova;

use App\Nova\Actions\ExportContestEntries;
use DmitryBubyakin\NovaMedialibraryField\Fields\GeneratedConversions;
use DmitryBubyakin\NovaMedialibraryField\Fields\Medialibrary;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;

class ContestSubmission extends Resource
{
    public static $group = 'Art Contest';

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\ContestSubmission::class;

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
    public function fields(Request $request): array
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),
            Text::make('Title'),
            Select::make('Status')->options(
                \App\Models\ContestSubmission::$statuses
            ),
            Select::make('Division')->options(
                \App\Models\ContestSubmission::$divisions
            )
                ->required(true),
            Select::make('Category')->options(
                \App\Models\ContestSubmission::$categories
            )
                ->required(true),
            Select::make('Medium')->options(
                \App\Models\ContestSubmission::$medium
            )
                ->required(true),
            Text::make('Link')
                ->hideFromIndex(),
            Trix::make('Connection')
                ->alwaysShow(),
            Medialibrary::make('Media', 'art', 'contest_submissions')->fields(function () {
                return [
                    GeneratedConversions::make('Conversions')
                        ->withTooltips(),
                ];
            }),
            HasMany::make('Contestants'),
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
            new ExportContestEntries(),
        ];
    }
}
