<?php

namespace App\Http\Controllers\Admin;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): View
    {
        /*$assignedItems = Item::query()
                            ->with('pending_actions', 'pending_page_actions')
                            ->whereHas('pending_actions', function (Builder $query) {
                                $query->where('assigned_to', auth()->id())
                                        ->whereNull('completed_at');
                            })
                            ->orWhereHas('pending_page_actions', function (Builder $query) {
                                $query->where('assigned_to', auth()->id())
                                    ->whereNull('completed_at');
                            })
                            ->get();*/

        return view('admin.dashboard', [

        ]);
    }
}
