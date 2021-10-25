<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotesController extends Controller
{
    //
    public function notes()
    {
        return view('admin.notes.notes-index');
    }
    
}
