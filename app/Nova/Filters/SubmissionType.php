<?php

namespace App\Nova\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class SubmissionType extends Filter
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
        return $query->where('form', $value);
    }

    /**
     * Get the filter's available options.
     */
    public function options(Request $request): array
    {
        return [
            'Contact' => 'Contact',
            'Contest Submission' => 'Contest Submission',
            'Contribute Documents' => 'Contribute Documents',
            'Media Request' => 'Media Request',
            'Testify' => 'Testify',
        ];
    }
}
