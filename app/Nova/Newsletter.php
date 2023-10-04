<?php

namespace App\Nova;

use App\Nova\Actions\ImportNewletters;
use DmitryBubyakin\NovaMedialibraryField\Fields\GeneratedConversions;
use DmitryBubyakin\NovaMedialibraryField\Fields\Medialibrary;
use Emilianotisato\NovaTinyMCE\NovaTinyMCE;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Newsletter extends Resource
{
    public static $group = 'Updates';

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Newsletter::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'subject';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
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
            Boolean::make('Enabled'),
            DateTime::make('Publish At'),
            Medialibrary::make('Media', 'images', 'updates')->fields(function () {
                return [
                    Boolean::make('Primary', 'custom_properties->primary'),

                    GeneratedConversions::make('Conversions')
                        ->withTooltips(),
                ];
            }),
            Text::make('subject'),
            Text::make('preheader')->hideFromIndex(),
            Text::make('link')->hideFromIndex(),
            NovaTinyMCE::make('Content', 'content')
                ->options([
                    'use_lfm' => true,
                    'height' => 500,
                ])
                ->asHtml()
                ->alwaysShow()
                ->help('The Article text should only be provided if the article was originally published on our site.'),
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
            new ImportNewletters,
        ];
    }
}
