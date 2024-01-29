<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\PeopleIdentification;
use Illuminate\Http\Request;

class UnknownPeopleController extends Controller
{
    public $categoriesMap = [

    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        abort_unless($request->ajax() || $request->user()->tokenCan('read'), 401);

        $people = PeopleIdentification::query()
            ->whereNotNull('link_to_ftp')
            ->whereNull('ftp_url_checked_at')
            ->paginate(20);

        return response()->json(
            $people
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        abort_unless($request->ajax() || $request->user()->tokenCan('update'), 401);

        $status = PeopleIdentification::where('id', $id)
            ->update([
                'ftp_url_checked_at' => now(),
                'ftp_status' => $request->input('ftp_status'),
            ]);

        return response()->json($status);
    }
}
