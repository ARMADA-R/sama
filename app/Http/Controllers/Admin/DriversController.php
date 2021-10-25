<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DriversController extends Controller
{
    //
    public function drivers()
    {
        return view('admin.transportation.drivers.drivers-index');
    }
}
