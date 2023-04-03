<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\Announcement;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        return view('announcements.index', [
            'announcements' => Announcement::paginate(15),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Announcement $announcement): View
    {
        return view('announcements.show', [
            'announcement' => $announcement,
        ]);
    }
}
