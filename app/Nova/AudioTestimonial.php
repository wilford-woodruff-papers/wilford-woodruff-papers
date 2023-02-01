<?php

namespace App\Nova;

use DmitryBubyakin\NovaMedialibraryField\Fields\GeneratedConversions;
use DmitryBubyakin\NovaMedialibraryField\Fields\Medialibrary;
use Emilianotisato\NovaTinyMCE\NovaTinyMCE;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;

class AudioTestimonial extends Resource
{
    public static $group = 'Testimonials';

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\AudioTestimonial::class;

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
            Boolean::make('Featured'),
            Text::make(__('Title'), 'title')
                ->required(true)
                ->sortable(),
            Text::make(__('Slug'), 'slug')
                ->hideFromIndex()
                ->hideWhenCreating()
                ->sortable()
                ->help('The slug is automatically generated, but can be updated if needed to make the URL more user friendly. It must be unique.'),
            Medialibrary::make('Media', 'images', 'testimonials')->fields(function () {
                return [
                    Boolean::make('Primary', 'custom_properties->primary'),

                    GeneratedConversions::make('Conversions')
                        ->withTooltips(),
                ];
            }),
            NovaTinyMCE::make('Excerpt')
                ->options([
                    'height' => 500,
                ])
                ->required(true)
                ->alwaysShow(),
            NovaTinyMCE::make('Content', 'content')
                ->options([
                    'use_lfm' => true,
                    'height' => 500,
                ])
                ->alwaysShow(),
            Text::make('Name')
                ->sortable(),
            Text::make('Age')
                ->sortable(),
            Text::make('Link')
                ->sortable(),
            NovaTinyMCE::make('Bio')
                ->options([
                    'height' => 500,
                ])
                ->required(true)
                ->alwaysShow(),
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
        return [];
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
        return [];
    }
}
