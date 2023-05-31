<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Page;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Builder;

class ApiWelcomeController extends Controller
{
    public function __invoke()
    {
        return view('dashboard', [
            'totalDocuments' => Item::query()->where('enabled', true)->count(),
            'totalPages' => Page::query()->whereHas('item', function (Builder $query) {
                $query->where('enabled', true);
            })->count(),
            'totalSubjects' => Subject::query()->where('total_usage_count', '>', 0)->count(),
        ]);
    }
}
