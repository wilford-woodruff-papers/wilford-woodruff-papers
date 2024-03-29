<?php

namespace App\Nova;

use App\Nova\Actions\ApproveComments;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Comment extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Comment::class;

    public static $with = ['commentable'];

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
            Boolean::make('Status'),
            DateTime::make('Created At')->sortable(),
            ID::make(__('ID'), 'id')->sortable(),
            BelongsTo::make('User'),
            Text::make('body', 'comment')->displayUsing(function ($value) {
                return str($value)->limit(30, '...');
            })->onlyOnIndex(),
            Text::make('Commented On', function ($comment) {
                if ($comment->commentable) {
                    return '<a href="'.route('landing-areas.ponder.press', ['press' => $comment->commentable->slug]).'" class="no-underline dim text-primary font-bold" target="_press">View</a>';
                } else {
                    return '';
                }
            })
                ->asHtml(),
            Text::make('body', 'comment')->hideFromIndex(),
            Number::make('total_likes'),
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
            new ApproveComments,
        ];
    }
}
