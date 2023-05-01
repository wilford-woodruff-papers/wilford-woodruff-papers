<?php

namespace App\Nova\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class Template extends Filter
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
        return $query->where('template_id', $value);
    }

    /**
     * Get the filter's available options.
     */
    public function options(Request $request): array
    {
        return \App\Models\Template::query()
            ->orderBy('name', 'ASC')
            ->pluck('id', 'name')
            ->toArray();
    }
}
