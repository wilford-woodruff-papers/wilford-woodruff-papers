<?php

namespace App\Nova\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class SubjectIsTagged extends Filter
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
        if ($value == 1) {
            $query = $query->where(function ($query) {
                $query->where('total_usage_count', '>', 0)
                    ->orWhere('tagged_count', '>', 0);
            });

        } elseif ($value == 0) {
            $query = $query->where('total_usage_count', 0);
        }

        return $query;
    }

    /**
     * Get the filter's available options.
     */
    public function options(Request $request): array
    {
        return [
            'Any' => -1,
            'Not Tagged' => 0,
            'Tagged' => 1,
        ];
    }
}
