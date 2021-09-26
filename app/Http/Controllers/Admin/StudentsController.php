<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\StudentsDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StudentsController extends Controller
{
    //
    public function students(StudentsDataTable $student)
    {
        // $this->authorize('viewAny', User::class);
        return ($student->render('admin.students.students-index'));
    }
}
