<?php

namespace App\Nova\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class Type extends Filter
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
    public function apply(Request $request, Builder $query, $value): Builder
    {
        if ($value == -1) {
            return $query->whereNull('type_id');
        }

        return $query->where('type_id', $value);
    }

    /**
     * Get the filter's available options.
     */
    public function options(Request $request): array
    {
        return ['Not Set' => -1] + \App\Models\Type::orderBy('name')->get()->pluck('id', 'name')->all();
    }
}
