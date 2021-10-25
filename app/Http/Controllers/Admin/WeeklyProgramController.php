<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WeeklyProgramController extends Controller
{
    //
    public function weeklyProgram()
    {
        return view('admin.weeklyProgram.weeklyProgram-index');
    }
}
