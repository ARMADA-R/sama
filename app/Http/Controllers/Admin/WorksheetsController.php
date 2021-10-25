<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WorksheetsController extends Controller
{
    //

    public function worksheets()
    {
        return view('admin.worksheets.worksheets-index');
    }
}
