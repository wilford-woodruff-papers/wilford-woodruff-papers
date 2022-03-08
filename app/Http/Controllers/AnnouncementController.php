<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('announcements.index', [
            'announcements' => Announcement::paginate(15),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  Announcement $announcement
     * @return \Illuminate\Http\Response
     */
    public function show(Announcement $announcement)
    {
        return view('announcements.show', [
            'announcement' => $announcement,
        ]);
    }
}
