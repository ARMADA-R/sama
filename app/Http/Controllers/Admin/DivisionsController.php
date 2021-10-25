<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\DivisionsDataTable;
use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Models\Level;
use App\Models\Stage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DivisionsController extends Controller
{
    //

    public function divisions(DivisionsDataTable $divisionsDataTable)
    {
        $this->authorize('viewAny', Division::class);
        return $divisionsDataTable->render('admin.divisions.divisions-index');
    }


    public function showCreateView()
    {
        $this->authorize('create', Division::class);
        $levels = Level::all();
        $stages = Stage::all();
        return view('admin.divisions.divisions-create', ['levels' => $levels, 'stages' => $stages]);
    }

    public function create(Request $request)
    {
        $this->authorize('create', Division::class);
        $data = ($request->all());
        $validatedData = Validator::make($data, [
            'title' => ['required', 'max:255'],
            'code' => ['required', 'max:255'],
            'capacity' => ['required', 'max:255'],
            'level_id' => ['required', 'max:255', 'exists:App\Models\Level,id'],
        ], [], [])->validate();
        
        Division::create($validatedData);

        return back()->with('success', trans('general.division_added_successfly'));
    }

    public function showUpdateView($id)
    {
        $this->authorize('view', Division::class);

        Validator::make(['id' => $id], [
            'id' => ['required', 'max:255', 'exists:App\Models\Division,id'],
        ], [], [])->validate();
        $division = Division::find($id);
        $divisionLevel = Level::where('id', $division->level_id)->first();
        $levels = Level::where('stage_id', $divisionLevel->stage_id)->get();
        $stages = Stage::all();
        return view('admin.divisions.divisions-edit', ['divisionLevel' => $divisionLevel, 'stages' => $stages, 'division' => $division, 'levels' => $levels]);
    }

    public function update(Request $request)
    {
        $this->authorize('update', Division::class);
        $data = ($request->all());
        $validatedData = Validator::make($data, [
            'id' => ['required', 'max:255', 'exists:App\Models\Division,id'],
            'title' => ['required', 'max:255'],
            'code' => ['required', 'max:255'],
        ], [], [])->validate();

        $division = Division::find($validatedData['id']);
        
        $division->title =$validatedData['title'];
        $division->code =$validatedData['code'];
        $division->save();

        return back()->with('success', trans('general.division_updated_successfly'));

    }


    public function delete(Request $request)
    {
        $this->authorize('delete', Division::class);
        $data = $request->all();
        Validator::make($data, [
            'division_id' => ['required', 'max:190', 'exists:App\Models\Division,id'],
        ], [], [])->validate();

        $parent = Division::find($data['division_id']);

        try {
            $parent->delete();
            return back()->with('success', trans('general.division_delete_successfully'));

        } catch (\Illuminate\Database\QueryException $th) {
            return back()->withErrors(trans('general.record_foreign_key_delete_error'));
            
        } catch (\Throwable $th) {
            return back()->withErrors(trans('general.record_delete_error'));
        }
    }
}
