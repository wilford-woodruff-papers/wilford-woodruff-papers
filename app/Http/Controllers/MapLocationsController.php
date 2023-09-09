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
            ->whereHas('pages', function (Builder $query) {
                $query->whereHas('item', function (Builder $query) {
                    $query->where('items.enabled', true);
                });
            })
            ->whereNotNull('latitude')
            ->whereHas('category', function (Builder $query) {
                $query->where('name', 'Places');
            })
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'url' => route('subjects.show', ['subject' => $item->slug]),
                    'description' => '',
                    'latitude' => $item->latitude,
                    'longitude' => $item->longitude,
                ];
            })
            ->toArray();
    }
}
