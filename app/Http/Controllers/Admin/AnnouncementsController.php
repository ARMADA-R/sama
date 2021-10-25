<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AnnouncementsController extends Controller
{
    //
    public function announcements()
    {
        return view('admin.announcements.announcements-index');
    }
}
