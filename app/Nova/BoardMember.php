<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use MichielKempen\NovaOrderField\Orderable;
use MichielKempen\NovaOrderField\OrderField;

class BoardMember extends Resource
{
    use Orderable;

    public static $displayInNavigation = false;

    public static $defaultOrderField = 'order';

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\BoardMember::class;

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
        'title',
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
            OrderField::make('Order'),
            Text::make(__('Name'), 'name')->sortable(),
            Text::make(__('Title'), 'title')->sortable(),
            Textarea::make(__('Bio'), 'bio')->alwaysShow(),
            File::make(__('Picture'), 'image')->disk('board_members'),
            Text::make('Youtube Link', 'video_link')
                ->required(false)
                ->hideFromIndex()
                ->help('Paste the YouTube URL in this box (not the embed code).'),
            File::make(__('Supporting Image'), 'supporting_image')->disk('board_members'),
            Text::make(__('Supporting Person Name'), 'supporting_person_name')->hideFromIndex(),
            Text::make(__('Supporting Person Description'), 'supporting_image_description')->hideFromIndex(),
            Text::make(__('Supporting Person Link'), 'supporting_person_link')->hideFromIndex(),
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
