<?php

namespace App\Nova\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class Role extends Filter
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
        if ($value == -1 || $value == '-1') {
            return $query->has('roles');
        } else {
            return $query->whereHas('roles', function (Builder $query) use ($value) {
                $query->where('id', $value);
            });
        }
    }

    /**
     * Get the filter's available options.
     */
    public function options(Request $request): array
    {
        return \App\Models\Role::query()
            ->orderBy('name', 'ASC')
            ->pluck('id', 'name')
            ->prepend(-1, 'Any Role')
            ->all();
    }
}
