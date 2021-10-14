<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\LevelsDataTable;
use App\Http\Controllers\Controller;
use App\Models\Level;
use App\Models\Stage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LevelsController extends Controller
{
    public function levels(LevelsDataTable $levelsDataTable)
    {
        $this->authorize('viewAny', Level::class);
        return $levelsDataTable->render('admin.levels.levels-index');
    }


    public function showCreateView()
    {
        $this->authorize('create', Level::class);
        $stages = Stage::all();
        $levels = Level::all();
        return view('admin.levels.levels-create', ['stages' => $stages, 'levels' => $levels]);
    }

    public function create(Request $request)
    {
        $this->authorize('create', Level::class);
        $data = ($request->all());
        $validatedData = Validator::make($data, [
            'title' => ['required', 'max:255'],
            'code' => ['required', 'max:255'],
            'parent' => ['nullable','max:255', 'exists:App\Models\Level,id'],
            'stage' => ['required', 'max:255', 'exists:App\Models\Stage,id'],
        ], [], [])->validate();
        
        
        Level::create([
            'title' => $data['title'],
            'code' => $data['code'],
            'parent_level' => $data['parent'],
            'stage_id' => $data['stage'],
        ]);

        return back()->with('success', trans('general.level_added_successfly'));

    }

    public function showUpdateView($id)
    {
        $this->authorize('view', Level::class);

        Validator::make(['id' => $id], [
            'id' => ['max:255', 'exists:App\Models\Level,id'],
        ], [], [])->validate();
        $stages = Stage::all();
        $level = Level::find($id);
        $levels = Level::where('stage_id', $level->stage_id)->get();
        return view('admin.levels.levels-edit', ['level' => $level, 'stages' => $stages, 'levels' => $levels]);
    }

    public function update(Request $request)
    {
        $this->authorize('update', Level::class);
        $data = ($request->all());
        $validatedData = Validator::make($data, [
            'id' => ['required', 'max:255', 'exists:App\Models\Level,id'],
            'title' => ['required', 'max:255'],
            'code' => ['required', 'max:255'],
            'parent' => ['nullable','max:255', 'exists:App\Models\Level,id'],
            'stage' => ['required', 'max:255', 'exists:App\Models\Stage,id'],
        ], [], [])->validate();

        $level = Level::find($validatedData['id']);
        
        $level->title =$validatedData['title'];
        $level->code =$validatedData['code'];
        $level->parent_level =$validatedData['parent'];
        $level->stage_id =$validatedData['stage'];
        $level->save();

        return back()->with('success', trans('general.level_updated_successfly'));

    }


    public function delete(Request $request)
    {
        $this->authorize('delete', Level::class);
        $data = $request->all();
        Validator::make($data, [
            'level_id' => ['required', 'max:190', 'exists:App\Models\Level,id'],
        ], [], [])->validate();

        $parent = Level::find($data['level_id']);

        try {
            $parent->delete();
            return back()->with('success', trans('general.level_delete_successfully'));

        } catch (\Illuminate\Database\QueryException $th) {
            return back()->withErrors(trans('general.record_foreign_key_delete_error'));
            
        } catch (\Throwable $th) {
            return back()->withErrors(trans('general.record_delete_error'));
        }
    }
}
