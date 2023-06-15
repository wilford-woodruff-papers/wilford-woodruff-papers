<?php

namespace App\Nova;

use Ctessier\NovaAdvancedImageField\AdvancedImage;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;

class ContentPage extends Resource
{
    public static $group = 'Website';

    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\ContentPage>
     */
    public static $model = \App\Models\ContentPage::class;

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
     *
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),
            Text::make('Title')
                ->sortable(),
            AdvancedImage::make('Banner Image')
                ->disk('content_pages')
                ->croppable()
                ->resize(1920)
                ->hideFromIndex(),
            DateTime::make('Created At')
                ->readonly(true)
                ->sortable(),
            Text::make('Preview', function ($page) {
                return '<a href="'.($page->id ? route('content-page.show', ['contentPage' => $page->slug]) : '#').'" class="no-underline dim text-primary font-bold" target="_preview">Preview</a>';
            })
                ->asHtml(),
            Textarea::make('Body')
                ->hideFromIndex(),
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
        return [];
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
        return [];
    }

    public function replicate()
    {
        return tap(parent::replicate(), function ($resource) {
            $model = $resource->model();

            $model->title = 'Duplicate of '.$model->title;
        });
    }
}
