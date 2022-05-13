<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Action;
use App\Models\Item;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $assignedItems = Item::query()
                            ->with('pending_actions', 'pending_page_actions')
                            ->whereHas('pending_actions', function (Builder $query){
                                $query->where('assigned_to', auth()->id())
                                        ->whereNull('completed_at');
                            })
                            ->orWhereHas('pending_page_actions', function (Builder $query){
                                $query->where('assigned_to', auth()->id())
                                    ->whereNull('completed_at');
                            })
                            ->get();

        return view('admin.dashboard', [

        ]);
    }
}
