<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExamsController extends Controller
{
    public function exams()
    {
        return view('admin.exams.exams-index');
    }
}
