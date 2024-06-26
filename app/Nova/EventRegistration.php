<?php

namespace App\Nova;

use App\Nova\Actions\ExportRegistrations;
use App\Nova\Filters\EventName;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class EventRegistration extends Resource
{
    public static $group = 'Website';

    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\EventRegistration>
     */
    public static $model = \App\Models\EventRegistration::class;

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

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),
            Text::make('Event Name')->sortable(),
            Text::make('First Name')->sortable(),
            Text::make('Last Name')->sortable(),
            Text::make('Email')->sortable(),
            Text::make('Other Questions', function (\App\Models\EventRegistration $registration) {
                $text = '';

                foreach ($registration->extra_attributes->all() as $key => $value) {
                    $text .= "<div style='margin: 8px 0px;'><b>{$key}</b><br>{$value}</div>";
                }

                return $text;

            })
                ->asHtml()
                ->onlyOnDetail(),
            DateTime::make('Created At')
                ->onlyOnIndex()
                ->sortable(),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [
            new EventName,
        ];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [
            new ExportRegistrations,
        ];
    }
}
