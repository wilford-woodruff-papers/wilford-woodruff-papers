<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Spatie\TagsField\Tags;

class Quote extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Quote::class;

    public static $with = ['page', 'creator', 'topics', 'tags', 'page.item'];

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'text';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'text',
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
            BelongsTo::make('Page')
                ->searchable(),
            Text::make('Text')
                ->displayUsing(function ($text) {
                    return Str::of($text)->limit('50', '...');
                })
                ->onlyOnIndex(),
            Textarea::make('Text')
                ->alwaysShow()
                ->readonly(true)
                ->hideFromIndex(),
            BelongsTo::make('Creator', 'creator', User::class)
                ->searchable(),
            BelongsToMany::make('Topics', 'topics', Topic::class)
                ->hideFromIndex(),
            Tags::make('Additional Topics', 'tags')
                ->type('quotes')
                ->withMeta(['placeholder' => 'Add additional topics...'])
                ->hideFromIndex()
                ->help('Type an additional topic and hit \'Enter\' to add it. Existing tags will appear below the box as you type and can be clicked to add.'),
        ];
    }

    public function breadcrumbResourceTitle()
    {
        return $this->id;
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
