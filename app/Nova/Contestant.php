<?php

namespace App\Nova;

use App\Nova\Actions\ExportContestants;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Contestant extends Resource
{
    public static $group = 'Art Contest';

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Contestant::class;

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
        'first_name',
        'last_name',
        'email',
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
            BelongsTo::make('Submission', 'submission', ContestSubmission::class),
            Text::make('First Name')->required(true),
            Text::make('Last Name')->required(true),
            Text::make('Email')->required(true)
                ->hideFromIndex(),
            Text::make('Phone')
                ->hideFromIndex(),
            Text::make('Address')
                ->hideFromIndex(),
            Boolean::make('Subscribe to Newsletter', 'subscribe_to_newsletter'),
            Boolean::make('Primary Contact', 'is_primary_contact'),
            Boolean::make('Original Work', 'is_original'),
            Boolean::make('Appropriate', 'is_appropriate'),
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
            new ExportContestants(),
        ];
    }
}
