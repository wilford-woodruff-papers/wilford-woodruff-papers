<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Action;
use App\Models\ActionType;
use App\Models\Quote;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;

class QuoteTaggingReport extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $quotes = [];
        $pages = [];

        $now = CarbonImmutable::now();

        $actionTypeId = ActionType::query()
            ->where('name', 'Quote Tagging')
            ->first()->id;

        for ($i = 0; $i < 12; $i++) {
            $quotes[] = Quote::query()
                ->whereNull('continued_from_previous_page')
                ->whereDate('created_at', '>=', $now->subMonth($i)->startOfMonth())
                ->whereDate('created_at', '<=', $now->subMonth($i)->endOfMonth())
                ->count();
            $pages[] = Action::query()
                ->whereNotNull('completed_at')
                ->where('action_type_id', $actionTypeId)
                ->where('actionable_type', 'App\Models\Page')
                ->whereDate('completed_at', '>=', $now->subMonth($i)->startOfMonth())
                ->whereDate('completed_at', '<=', $now->subMonth($i)->endOfMonth())
                ->count();
        }

        return view('admin.dashboard.quote-tagging-report', [
            'now' => $now,
            'quotes' => $quotes,
            'pages' => $pages,
        ]);
    }
}
