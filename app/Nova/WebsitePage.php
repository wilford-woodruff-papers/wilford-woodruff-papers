<?php

namespace App\Nova;

use Ayvazyan10\Imagic\Imagic;
use Ctessier\NovaAdvancedImageField\AdvancedImage;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Http\Requests\NovaRequest;
use Spatie\TagsField\Tags;

class WebsitePage extends Resource
{
    public static $group = 'Website';

    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\WebsitePage>
     */
    public static $model = \App\Models\WebsitePage::class;

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
            //            Imagic::make('Thumbnail')
            //                ->disk('spaces')
            //                ->fit(300, 300)
            //                ->convert(false),
            AdvancedImage::make('Thumbnail')
                ->disk('website')
                ->resize(null, 300)
                ->croppable(false),
            Text::make('Url'),
            Text::make('Name'),
            Trix::make('Description'),
            Tags::make('Keywords', 'tags')
                ->type('website')
                ->withMeta(['placeholder' => 'Add keywords...'])
                ->help('Type a keyword and hit \'Enter\' to add it. Existing keywords will appear below the box as you type and can be clicked to add.'),
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
}
