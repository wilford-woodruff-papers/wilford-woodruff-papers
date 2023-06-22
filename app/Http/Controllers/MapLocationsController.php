<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Database\Eloquent\Builder;

class MapLocationsController extends Controller
{
    public function __invoke()
    {
        return Subject::query()
            ->select(['id', 'name', 'slug', 'latitude', 'longitude', 'geolocation'])
            ->with([
                'category',
            ])
            ->whereNotNull('geolocation')
            ->whereHas('category', function (Builder $query) {
                $query->where('name', 'Places');
            })
            ->limit(10)
            ->get()
            ->map(function ($item) {
                return [
                    'name' => $item->name,
                    'url' => route('subjects.show', ['subject' => $item->slug]),
                    'description' => '',
                    'latitude' => data_get($item->geolocation, 'geometry.location.lat'),
                    'longitude' => data_get($item->geolocation, 'geometry.location.lng'),
                ];
            })
            ->toArray();
    }
}
