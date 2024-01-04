<?php

namespace App\Nova;

use App\Nova\Actions\IndexPress;
use App\Nova\Metrics\CreatedPerMonth;
use Emilianotisato\NovaTinyMCE\NovaTinyMCE;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Spatie\TagsField\Tags;

class Article extends Resource
{
    public static $group = 'Media';

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Article::class;

    public static $with = ['tags'];

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
        'title',
        'subtitle',
        'description',
        'transcript',
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
            Image::make(__('Cover Image'), 'cover_image')
                ->disk('media')
                ->hideFromIndex()
                ->help('A cover image is required to display articles on the homepage'),
            Text::make(__('Title'), 'title')
                ->required(true)
                ->displayUsing(function ($value) {
                    return '<a href="'.(! empty($this?->slug) ? route('media.article', ['article' => $this->slug]) : '').'" class="no-underline dim text-primary font-bold" target="_blank" title="Click for preview on website">'.str($value)->limit('40', '...').'</a>';
                })
                ->asHtml(),
            Text::make(__('Slug'), 'slug')
                ->hideFromIndex()
                ->hideWhenCreating()
                ->help('The slug is automatically generated, but can be updated if needed to make the URL more user friendly. It must be unique.'),
            Date::make(__('Publish At'), 'date')
                ->required(true)
                ->sortable(),
            Text::make(__('Author Name(s)'), 'subtitle')
                ->displayUsing(function ($subtitle) {
                    return Str::of($subtitle)->limit('50', ' ...');
                }),
            Text::make(__('Publisher Name'), 'publisher')
                ->help('Examples: Meridian Magazine, Work + Wonder, The LDS Women Project, Digital Journal, Deseret News, Y Magazine. Used for link when linking to external site.'),
            NovaTinyMCE::make('Excerpt')
                ->options([
                    'height' => 500,
                ])
                ->asHtml()
                ->required(true)
                ->alwaysShow(),
            NovaTinyMCE::make('Article', 'description')
                ->options([
                    'use_lfm' => true,
                    'height' => 500,
                ])
                ->asHtml()
                ->alwaysShow()
                ->help('The Article text should only be provided if the article was originally published on our site.'),
            NovaTinyMCE::make('Footnotes')
                ->options([
                    'height' => 500,
                ])
                ->asHtml()
                ->alwaysShow(),
            Text::make('Link')
                ->hideFromIndex()
                ->help('A link to the article should be provided if the Article is published on an external site.'),
            Boolean::make('Open in New Window?', 'external_link_only'),
            BelongsToMany::make('Authors')->hideFromIndex(),
            Tags::make('Category', 'tags')
                ->type('articles')
                ->withMeta(['placeholder' => 'Add categories...'])
                ->help('Type a category and hit \'Enter\' to add it. Existing tags will appear below the box as you type and can be clicked to add.'),
            BelongsToMany::make('Topics', 'topLevelIndexTopics', 'App\Nova\TopLevelTopic')
                ->searchable(),
        ];
    }

    /**
     * Get the cards available for the request.
     */
    public function cards(Request $request): array
    {
        return [
            new CreatedPerMonth(\App\Models\Article::class),
        ];
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
            new IndexPress('Articles'),
        ];
    }
}
