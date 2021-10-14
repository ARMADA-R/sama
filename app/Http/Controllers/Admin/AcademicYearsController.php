<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\AcademicYearsDataTable;
use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AcademicYearsController extends Controller
{
    
    
    public function academicYears(AcademicYearsDataTable $academicYearsDataTable)
    {
        $this->authorize('viewAny', AcademicYear::class);
        return $academicYearsDataTable->render('admin.academic-years.academic-years-index');
    }


    public function showCreateView()
    {
        $this->authorize('create', AcademicYear::class);
        return view('admin.academic-years.academic-years-create');
    }

    public function create(Request $request)
    {
        $this->authorize('create', AcademicYear::class);
        $data = ($request->all());
        $validatedData = Validator::make($data, [
            'title' => ['required', 'max:255'],
            'code' => ['required', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
        ], [], [])->validate();
        
        
        AcademicYear::create($validatedData);

        return back()->with('success', trans('general.academic_year_added_successfly'));

    }

    public function showUpdateView($id)
    {
        $this->authorize('view', AcademicYear::class);
        Validator::make(['id' => $id], [
            'id' => ['required', 'max:255', 'exists:App\Models\AcademicYear,id'],
        ], [], [])->validate();
        $academicYear = AcademicYear::find($id);

        return view('admin.academic-years.academic-years-edit', ['academicYear' => $academicYear]);
    }

    public function update(Request $request)
    {
        $this->authorize('update', AcademicYear::class);
        $data = ($request->all());
        $validatedData = Validator::make($data, [
            'id' => ['required', 'max:255', 'exists:App\Models\AcademicYear,id'],
            'title' => ['required', 'max:255'],
            'code' => ['required', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
        ], [], [])->validate();

        $academicYear = AcademicYear::find($validatedData['id']);
        
        $academicYear->title =$validatedData['title'];
        $academicYear->code =$validatedData['code'];
        $academicYear->start_date =$validatedData['start_date'];
        $academicYear->end_date =$validatedData['end_date'];
        $academicYear->save();

        return back()->with('success', trans('general.academic_year_updated_successfly'));

    }


    public function delete(Request $request)
    {
        $this->authorize('delete', AcademicYear::class);
        $data = $request->all();
        Validator::make($data, [
            'academic_year_id' => ['required', 'max:190', 'exists:App\Models\AcademicYear,id'],
        ], [], [])->validate();

        $academicYear = AcademicYear::find($data['academic_year_id']);

        try {
            $academicYear->delete();
            return back()->with('success', trans('general.academic_year_delete_successfully'));

        } catch (\Illuminate\Database\QueryException $th) {
            return back()->withErrors(trans('general.record_foreign_key_delete_error'));
            
        } catch (\Throwable $th) {
            return back()->withErrors(trans('general.record_delete_error'));
        }
    }
}
