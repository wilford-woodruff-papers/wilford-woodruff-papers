<?php

namespace App\Nova\Metrics;

use App\Models\Page;
use App\Models\Type;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;

class NewPages extends Value
{
    /**
     * Calculate the value of the metric.
     *
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        $pages = new Page;
        if ($request->range > 0) {
            $pages = $pages->whereHas('item', function (Builder $query) use ($request) {
                $query->where('type_id', $request->range)
                    ->where('enabled', 1);
            });
        } else {
            $pages = $pages->whereHas('item', function (Builder $query) {
                $query->whereIn('type_id', array_keys($this->ranges()))
                    ->where('enabled', 1);
            });
        }

        return $this->result($pages->count())
            ->format('0,0');
    }

    /**
     * Get the ranges available for the metric.
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
     */
    public function uriKey(): string
    {
        return 'new-pages';
    }

    public function name()
    {
        return 'Published Pages';
    }
}
