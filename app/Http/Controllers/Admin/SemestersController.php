<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\SemestersDataTable;
use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SemestersController extends Controller
{
    
    public function semesters(SemestersDataTable $semestersDataTable)
    {
        $this->authorize('viewAny', Semester::class);
        return $semestersDataTable->render('admin.semesters.semesters-index');
    }


    public function showCreateView()
    {
        $this->authorize('create', Semester::class);
        $academicYears = AcademicYear::all();
        return view('admin.semesters.semesters-create', ['academicYears' => $academicYears]);
    }

    public function create(Request $request)
    {
        $this->authorize('create', Semester::class);
        $data = ($request->all());
        $validatedData = Validator::make($data, [
            'title' => ['required', 'max:255'],
            'code' => ['required', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
            'academic_year_id' => ['required', 'max:255', 'exists:App\Models\AcademicYear,id'],
        ], [], [])->validate();
        
        
        Semester::create($validatedData);

        return back()->with('success', trans('general.semester_added_successfly'));

    }

    public function showUpdateView($id)
    {
        $this->authorize('view', Semester::class);

        Validator::make(['id' => $id], [
            'id' => ['required', 'max:255', 'exists:App\Models\Semester,id'],
        ], [], [])->validate();
        $semester = Semester::find($id);
        $academicYears = AcademicYear::all();
        return view('admin.semesters.semesters-edit', ['semester' => $semester, 'academicYears' => $academicYears]);
    }

    public function update(Request $request)
    {
        $this->authorize('update', Semester::class);
        $data = ($request->all());
        $validatedData = Validator::make($data, [
            'id' => ['required', 'max:255', 'exists:App\Models\Semester,id'],
            'title' => ['required', 'max:255'],
            'code' => ['required', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
            'academic_year_id' => ['required', 'max:255', 'exists:App\Models\AcademicYear,id'],
        ], [], [])->validate();

        $semester = Semester::find($validatedData['id']);
        
        $semester->title =$validatedData['title'];
        $semester->code =$validatedData['code'];
        $semester->start_date =$validatedData['start_date'];
        $semester->end_date =$validatedData['end_date'];
        $semester->academic_year_id =$validatedData['academic_year_id'];
        $semester->save();

        return back()->with('success', trans('general.semester_updated_successfly'));

    }


    public function delete(Request $request)
    {
        $this->authorize('delete', Semester::class);
        $data = $request->all();
        Validator::make($data, [
            'semester_id' => ['required', 'max:190', 'exists:App\Models\Semester,id'],
        ], [], [])->validate();

        $semester = Semester::find($data['semester_id']);

        try {
            $semester->delete();
            return back()->with('success', trans('general.semester_delete_successfully'));

        } catch (\Illuminate\Database\QueryException $th) {
            return back()->withErrors(trans('general.record_foreign_key_delete_error'));
            
        } catch (\Throwable $th) {
            return back()->withErrors(trans('general.record_delete_error'));
        }
    }
}
