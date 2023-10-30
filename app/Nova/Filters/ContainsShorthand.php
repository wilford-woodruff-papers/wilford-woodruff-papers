<?php

namespace App\Nova\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\BooleanFilter;

class ContainsShorthand extends BooleanFilter
{
    /**
     * Apply the filter to the given query.
     *
     * @param  mixed  $value
     */
    public function apply(Request $request, $query, $value): Builder
    {
        return $query->when($value['shorthand'], function (Builder $query, bool $authorized) {
            $query
                ->where('transcript', 'LIKE', '%shorthand%')
                ->orWhere('transcript', 'LIKE', '%illegible%')
                ->orWhere('transcript', 'LIKE', '%{%}%');
        });
    }

    /**
     * Get the filter's available options.
     */
    public function options(Request $request): array
    {
        return [
            'Contains Shorthand' => 'shorthand',
        ];
    }
}
