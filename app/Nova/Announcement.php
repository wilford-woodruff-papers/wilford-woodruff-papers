<?php

namespace App\Nova;

use Emilianotisato\NovaTinyMCE\NovaTinyMCE;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;

class Announcement extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Announcement::class;

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
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),
            Select::make('Type', 'type')->options([
                'index_only' => 'Only on index page of announcements',
                'homepage_top' => 'In top section of homepage',
                'homepage_bottom' => 'In bottom section of homepage',
            ]),
            Image::make(__('Image'), 'image')
                ->required(true)
                ->disk('announcements'),
            Text::make(__('Title'), 'title')
                ->required(true)
                ->sortable(),
            Text::make(__('Slug'), 'slug')
                ->hideFromIndex()
                ->hideWhenCreating()
                ->help('The slug is automatically generated, but can be updated if needed to make the URL more user friendly. It must be unique.'),
            NovaTinyMCE::make('Description', 'description')
                ->options([
                    'height' => 500,
                ])
                ->alwaysShow(),
            DateTime::make(__('Start Showing'), 'start_publishing_at')
                ->required(true)
                ->sortable(),
            DateTime::make(__('Stop Showing'), 'end_publishing_at')
                ->sortable(),
            Text::make('Preview', function ($model) {
                return '<a href="'.route('announcements.show', ['announcement' => $model->slug]).'" target="_blank">Preview</a>';
            })
                ->asHtml(),
            Text::make('Link')
                ->hideFromIndex(),
            Text::make(__('Button Text'), 'button_text')
                ->hideFromIndex(),
            Text::make(__('Button Link'), 'button_link')
                ->hideFromIndex(),
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
