<?php

namespace App\Nova\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\BooleanFilter;

class ApiUser extends BooleanFilter
{
    /**
     * Apply the filter to the given query.
     *
     * @param  mixed  $value
     */
    public function apply(Request $request, $query, $value): Builder
    {
        return $query->when($value['authorized'], function (Builder $query, bool $authorized) {
            $query->where('accepted_terms', true)
                ->where('provided_api_fields', true);
        });
    }

    /**
     * Get the filter's available options.
     */
    public function options(Request $request): array
    {
        return [
            'Authorized to use API' => 'authorized',
        ];
    }
}
