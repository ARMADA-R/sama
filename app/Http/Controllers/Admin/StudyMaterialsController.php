<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\StudyMaterialsDataTable;
use App\Http\Controllers\Controller;
use App\Models\Level;
use App\Models\Stage;
use App\Models\StudyMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudyMaterialsController extends Controller
{
    public function studyMaterials(StudyMaterialsDataTable $studyMaterialsDataTable)
    {
        // $this->authorize('viewAny', StudyMaterial::class);
        return $studyMaterialsDataTable->render('admin.study-materials.study-materials-index');
    }


    public function showCreateView()
    {
        // $this->authorize('create', StudyMaterial::class);
        $stages = Stage::all();
        return view('admin.study-materials.study-materials-create', ['stages' => $stages]);
    }

    public function create(Request $request)
    {
        // $this->authorize('create', StudyMaterial::class);
        $data = ($request->all());
        $validatedData = Validator::make($data, [
            'title' => ['required', 'max:255'],
            'min_grade' => ['required', 'numeric'],
            'max_grade' => ['required', 'numeric'],
            'description' => ['required', 'max:25500'],
            'level_id' => ['required', 'max:255', 'exists:App\Models\Level,id'],
            'attachments' => ['file', 'max:5120'],
        ], [], [])->validate();

        if (isset($validatedData['attachments'])) {
            $path = $request->file('attachments')->store('attachments');
            $validatedData['attachments'] = $path;
        }

        StudyMaterial::create($validatedData);
        return back()->with('success', trans('general.studyMaterial_added_successfly'));
    }

    public function showUpdateView($id)
    {
        // $this->authorize('view', StudyMaterial::class);

        Validator::make(['id' => $id], [
            'id' => ['required', 'max:255', 'exists:App\Models\StudyMaterial,id'],
        ], [], [])->validate();
        $studyMaterial = StudyMaterial::find($id);
        $stages = Stage::all();
        $currentLevel = Level::find($studyMaterial->level_id);
        $levels = Level::where('stage_id', $currentLevel->stage_id)->get();

        return view('admin.study-materials.study-materials-edit', ['stages' => $stages, 'currentLevel' => $currentLevel, 'studyMaterial' => $studyMaterial, 'levels' => $levels]);
    }

    public function update(Request $request)
    {
        // $this->authorize('update', StudyMaterial::class);

        $data = ($request->all());
        $validatedData = Validator::make($data, [
            'id' => ['required', 'max:255', 'exists:App\Models\StudyMaterial,id'],
            'title' => ['required', 'max:255'],
            'min_grade' => ['required', 'numeric'],
            'max_grade' => ['required', 'numeric'],
            'description' => ['required', 'max:25500'],
            'level_id' => ['required', 'max:255', 'exists:App\Models\Level,id'],
            'attachments' => ['nullable', 'file', 'max:5120'],
        ], [], [])->validate();

        $studyMaterial = StudyMaterial::find($validatedData['id']);


        if (isset($validatedData['attachments'])) {
            $path = $request->file('attachments')->store('attachments');
            $validatedData['attachments'] = $path;
            $studyMaterial->attachments = $validatedData['attachments'];
        }
        
        $studyMaterial->title = $validatedData['title'];
        $studyMaterial->min_grade = $validatedData['min_grade'];
        $studyMaterial->max_grade = $validatedData['max_grade'];
        $studyMaterial->description = $validatedData['description'];
        $studyMaterial->level_id = $validatedData['level_id'];
        $studyMaterial->save();

        return back()->with('success', trans('general.recorde_updated_successflly'));
    }


    public function delete(Request $request)
    {
        // $this->authorize('delete', StudyMaterial::class);
        $data = $request->all();
        Validator::make($data, [
            'studyMaterial_id' => ['required', 'max:190', 'exists:App\Models\StudyMaterial,id'],
        ], [], [])->validate();

        $parent = StudyMaterial::find($data['studyMaterial_id']);

        try {
            $parent->delete();
            return back()->with('success', trans('general.recorde_deleted_successfully'));
        } catch (\Illuminate\Database\QueryException $th) {
            return back()->withErrors(trans('general.record_foreign_key_delete_error'));
        } catch (\Throwable $th) {
            return back()->withErrors(trans('general.record_delete_error'));
        }
    }
}
