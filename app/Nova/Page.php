<?php

namespace App\Nova;

use App\Nova\Actions\ExportPages;
use App\Nova\Actions\ExportPagesAlternate;
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
    public static $title = 'full_name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'full_name',
        'transcript',
        'uuid',
    ];

    /**
     * Get the fields displayed by the resource.
     */
    public function fields(NovaRequest $request): array
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),
            BelongsTo::make('Item'),
            Text::make(__('Name'), 'name')->help('Field is overwritten on import')->sortable(),
            (! empty($this->item) ?
                Text::make('Preview', function () {
                    return '<a href="'.route('pages.show', ['item' => $this->item, 'page' => $this]).'" class="no-underline dim text-primary font-bold" target="_preview">Preview</a>';
                })->asHtml() : Text::make('Preview', function () {
                    return '<a href="#" class="no-underline dim text-primary font-bold" target="_preview">Preview</a>';
                })->asHtml()),
            (! empty($this->id) ? Text::make('Short', function () {
                return '<span class="no-underline dim text-primary font-bold cursor-pointer" data-url="'.route('short-url.page', ['hashid' => $this->hashid()]).'" onclick="copyShortUrlToClipboard(this)">Short</a>';
            })->asHtml() : Text::make('Short', function () {
                return '<span class="no-underline dim text-primary font-bold cursor-pointer">N/A</a>';
            })->asHtml()),
            Text::make('FTP', function () {
                return '<a href="'.$this->ftp_link.'" class="no-underline dim text-primary font-bold" target="_preview">FTP</a>';
            })->asHtml(),
            Trix::make(__('Transcript'), 'transcript')->help('Field is overwritten on import')->alwaysShow(),
            HasMany::make('Media'),
            MorphToMany::make(__('Events')),
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
            (new ExportPages)
                ->askForWriterType(),
            (new ExportPagesAlternate())
                ->askForWriterType(),
        ];
    }
}
