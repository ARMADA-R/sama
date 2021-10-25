<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BusesController extends Controller
{
    //
    public function buses()
    {
        return view('admin.transportation.buses.buses-index');
    }
}
