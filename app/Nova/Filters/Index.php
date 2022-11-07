<?php

namespace App\Nova\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class Index extends Filter
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
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Request $request, $query, $value)
    {
        if ($value == -1) {
        } else {
            $query = $query->where(function ($query) {
                $query->whereNull('subject_id')
                    ->orWhere('subject_id', 0);
            })
            ->whereHas('category', function (Builder $query) use ($value) {
                $query->where('id', $value);
            });
        }

        return $query;
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function options(Request $request)
    {
        return ['Not Set' => -1] + \App\Models\Category::firstWhere('name', 'Index')->pluck('id', 'name')->all();
    }
}
