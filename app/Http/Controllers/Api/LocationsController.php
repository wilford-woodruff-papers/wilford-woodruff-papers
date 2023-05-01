<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class LocationsController extends Controller
{
    public function __invoke(Request $request)
    {
        $locations = new Subject();
        $locations = $locations
            ->query()
            ->select('id', 'name')
            ->whereHas('category', function (Builder $query) {
                $query->whereIn('categories.name', ['Places']);
            });
        if ($request->has('q')) {
            $locations = $locations->where('name', 'like', $request->get('q').'%');
        }

        $locations = $locations
            ->orderBy('name')
            ->limit(100)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'text' => $item->name,
                ];

            });

        return response()->json([
            'results' => $locations,
        ]);

    }
}
