<?php

namespace App\Nova;

use App\Exports\PageExport;
use App\Nova\Actions\ExportPages;
use App\Nova\Actions\ImportSubjects;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphToMany;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Http\Requests\NovaRequest;

class Page extends Resource
{
    public static $group = 'Documents';
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Page::class;

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
        'transcript',
        'uuid'
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
            BelongsTo::make('Item'),
            Text::make(__('Name'), 'name')->help('Field is overwritten on import')->sortable(),
            ($this->item) ?
                Text::make('Preview', function () {
                    return '<a href="'.route('pages.show', ['item' => $this->item, 'page' => $this]).'" class="no-underline dim text-primary font-bold" target="_preview">Preview</a>';
                })->asHtml() : Text::make('Preview', function () {
                return '<a href="#" class="no-underline dim text-primary font-bold" target="_preview">Preview</a>';
            })->asHtml(),
            Text::make('FTP', function () {
                return '<a href="' . $this->ftp_link . '" class="no-underline dim text-primary font-bold" target="_preview">FTP</a>';
            })->asHtml(),
            Trix::make(__('Transcript'), 'transcript')->help('Field is overwritten on import')->alwaysShow(),
            HasMany::make('Media'),
            MorphToMany::make(__('Events')),
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
        return [
            (new ExportPages)
                ->askForWriterType(),
        ];
    }
}
