<?php

namespace App\Nova\Metrics;

use App\Models\Item;
use App\Models\Type;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;

class PublishedItems extends Value
{
    /**
     * Calculate the value of the metric.
     *
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        $items = new Item;
        if ($request->range > 0) {
            $items = $items->where('type_id', $request->range);
        } else {
            $items = $items->whereIn('type_id', array_keys($this->ranges()));
        }

        return $this->result($items->where('enabled', 1)->count())
            ->format('0,0');
    }

    /**
     * Get the ranges available for the metric.
     *
     * @return array
     */
    public function ranges(): array
    {
        return [-1 => 'All Item Types'] + Type::orderBy('name', 'ASC')->pluck('name', 'id')->all();
    }

    /**
     * Determine for how many minutes the metric should be cached.
     *
     * @return  \DateTimeInterface|\DateInterval|float|int
     */
    public function cacheFor()
    {
        // return now()->addMinutes(5);
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey(): string
    {
        return 'published-items';
    }
}
