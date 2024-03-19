<?php

namespace App\Nova\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class PhotoCategory extends Filter
{
    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'select-filter';

    /**
     * Apply the filter to the given query.
     *
     * @param  mixed  $value
     */
    public function apply(Request $request, $query, $value): Builder
    {
        $query = $query->withAnyTags([$value], 'photos');

        return $query;
    }

    /**
     * Get the filter's available options.
     */
    public function options(Request $request): array
    {
        return \Spatie\Tags\Tag::withType('photos')
            ->orderBy('name')
            ->get()
            ->pluck('name', 'name')
            ->all();
    }
}
