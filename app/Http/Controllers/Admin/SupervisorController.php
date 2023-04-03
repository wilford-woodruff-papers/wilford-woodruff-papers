<?php

namespace App\Http\Controllers\Admin;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Type;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class SupervisorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        $users = User::query()
                        /*->has('pending_actions')*/
                        ->whereHas('pending_actions', function (Builder $query) {
                            $query->whereHasMorph('actionable',
                                [Item::class],
                                function (Builder $query) {
                                    $query->whereIn('type_id', Type::query()->role(auth()->user()->roles->pluck('id')->all())->pluck('id')->all());
                                });
                        })
                        ->orderBy('name', 'ASC')
                        ->get();

        return view('admin.supervisor.index', [
            'users' => $users,
        ]);
    }
}
