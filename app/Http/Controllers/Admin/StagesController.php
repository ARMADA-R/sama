<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\StagesDataTable;
use App\Http\Controllers\Controller;
use App\Models\Headmaster;
use App\Models\Level;
use App\Models\Stage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StagesController extends Controller
{
    //

    public function stages(StagesDataTable $stagesDataTable)
    {
        $this->authorize('viewAny', Stage::class);
        return $stagesDataTable->render('admin.stages.stages-index');
    }


    public function showCreateView()
    {
        $this->authorize('create', Stage::class);
        return view('admin.stages.stages-create');
    }

    public function create(Request $request)
    {
        $this->authorize('create', Stage::class);
        $data = ($request->all());
        $validatedData = Validator::make($data, [
            'title' => ['required', 'max:255'],
            'code' => ['required', 'max:255'],
        ], [], [])->validate();


        Stage::create($validatedData);

        return back()->with('success', trans('general.stage_added_successfly'));
    }

    public function showUpdateView($id)
    {
        $this->authorize('view', Stage::class);

        Validator::make(['id' => $id], [
            'id' => ['required', 'max:255', 'exists:App\Models\Stage,id'],
        ], [], [])->validate();
        $stage = Stage::find($id);
        $headmasters = Headmaster::orderBy('created_at')->get();
        return view('admin.stages.stages-edit', ['stage' => $stage, 'headmasters' => $headmasters]);
    }

    public function update(Request $request)
    {
        $this->authorize('update', Stage::class);
        $data = ($request->all());
        $validatedData = Validator::make($data, [
            'id' => ['required', 'max:255', 'exists:App\Models\Stage,id'],
            'title' => ['required', 'max:255'],
            'code' => ['required', 'max:255'],
            'headmaster' => ['nullable', 'max:255', 'exists:App\Models\Headmaster,id'],
        ], [], [])->validate();

        $stage = Stage::find($validatedData['id']);

        $stage->title = $validatedData['title'];
        $stage->code = $validatedData['code'];
        $stage->headmaster_id = $validatedData['headmaster'];
        $stage->save();

        return back()->with('success', trans('general.stage_updated_successfly'));
    }


    public function delete(Request $request)
    {
        $this->authorize('delete', Stage::class);
        $data = $request->all();
        Validator::make($data, [
            'stage_id' => ['required', 'max:190', 'exists:App\Models\Stage,id'],
        ], [], [])->validate();

        $parent = Stage::find($data['stage_id']);

        try {
            $parent->delete();
            return back()->with('success', trans('general.stage_delete_successfully'));
        } catch (\Illuminate\Database\QueryException $th) {
            return back()->withErrors(trans('general.record_foreign_key_delete_error'));
        } catch (\Throwable $th) {
            return back()->withErrors(trans('general.record_delete_error'));
        }
    }

    // return all stage levels that have at least one division
    public function getStageLevelsHaveDivisions(Request $request)
    {
        $stage_id = $request->input('stage_id');
        if ($stage_id) {
            $levels = Level::select('levels.*')->where('stage_id', $stage_id)->distinct()
            ->join('divisions', 'divisions.level_id', '=', 'levels.id')->get();
            $data = [
                "code" => 1,
                "data" => $levels,
                "msg" => ""
            ];

            return response($data, 200);
        }

        $data = [
            "code" => 1,
            "data" => [],
            "msg" => ""
        ];

        return response($data, 200);
    }

    // return all stage levels
    public function getStageLevels(Request $request)
    {
        $stage_id = $request->input('stage_id');
        if ($stage_id) {
            $levels = Level::where('stage_id', $stage_id)->get();
            $data = [
                "code" => 1,
                "data" => $levels,
                "msg" => ""
            ];

            return response($data, 200);
        }

        $data = [
            "code" => -1,
            "data" => [],
            "msg" => "you must set stage value!"
        ];

        return response($data, 400);
    }
}
