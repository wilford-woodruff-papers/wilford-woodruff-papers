<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Http\Requests\NovaRequest;
use MichielKempen\NovaOrderField\Orderable;
use MichielKempen\NovaOrderField\OrderField;

class Faq extends Resource
{
    use Orderable;

    public static $group = 'Website';

    public static $defaultOrderField = 'order_column';

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Faq::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'question';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'question',
        'answer',
    ];

    /**
     * Get the fields displayed by the resource.
     */
    public function fields(NovaRequest $request): array
    {
        return [
            OrderField::make('Order'),
            ID::make(__('ID'), 'id')->sortable(),
            Select::make(__('Category'), 'category')->options([
                'Project' => 'Project',
                'Documents' => 'Documents',
                'Funding' => 'Funding',
            ])->sortable(),
            Text::make(__('Question'), 'question')->sortable(),
            Trix::make(__('Answer'), 'answer'),
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
