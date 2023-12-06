<?php

namespace App\Nova;

use Emilianotisato\NovaTinyMCE\NovaTinyMCE;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

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
     */
    public function fields(NovaRequest $request): array
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
                ->asHtml(),
            DateTime::make(__('Start Showing'), 'start_publishing_at')
                ->required(true)
                ->sortable(),
            DateTime::make(__('Stop Showing'), 'end_publishing_at')
                ->sortable(),
            Number::make('Order', 'order_column')
                ->help('The order is usually determined by the "Stop Showing" date. You can use this field to override that order.'),
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
