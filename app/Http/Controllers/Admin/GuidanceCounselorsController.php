<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\GuidanceCounselorsDataTable;
use App\Http\Controllers\Controller;
use App\Models\GuidanceCounselor;
use App\Models\Stage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class GuidanceCounselorsController extends Controller
{

    public function guidanceCounselors(GuidanceCounselorsDataTable $guidanceCounselorsDataTable)
    {
        // $this->authorize('viewAny', GuidanceCounselor::class);
        return ($guidanceCounselorsDataTable->render('admin.guidance-counselors.guidance-counselors-index'));
    }


    public function showCreateView()
    {
        $stages = Stage::all();
        return view('admin.guidance-counselors.guidance-counselors-create', ['stages' => $stages]);
    }

    public function create(Request $request)
    {
        // $this->authorize('create', GuidanceCounselor::class);
        $data = ($request->all());
        Validator::make($data, [
            'firstName' => ['required', 'max:255'],
            'lastName' => ['required', 'max:255'],
            'email' => ['required', 'unique:headmasters', 'max:255', 'email'],
            'phone' => ['required'],
            'username' => ['required', 'max:255'],
            'password' => ['required', Password::min(6)],
            'stage_id' => ['required', 'max:255', 'exists:App\Models\Stage,id'],
        ], [], [])->validate();

        GuidanceCounselor::create([
            'first_name' => $data['firstName'],
            'last_name' => $data['lastName'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'username' => $data['username'],
            'stage_id' => $data['stage_id'],
            'password' => Hash::make($data['password']),
            'settings' => ('{"status": "1"}'),
        ]);

        return back()->with('success', trans('general.account_created'));
    }




    public function showUpdateView($id)
    {
        // $this->authorize('view', GuidanceCounselor::class);
        Validator::make(['id' => $id], [
            'id' => ['required', 'max:255', 'exists:App\Models\GuidanceCounselor,id'],
        ], [], [])->validate();
        
        $guidanceCounselor = GuidanceCounselor::find($id);
        $stages = Stage::all();
        return view('admin.guidance-counselors.guidance-counselors-edit', ['stages' => $stages, 'guidanceCounselor' => $guidanceCounselor]);
    }

    public function update(Request $request, $id)
    {
        // $this->authorize('update', GuidanceCounselor::class);
        $data = ($request->all());
        Validator::make($data, [
            'id' => ['required', 'max:255', 'exists:App\Models\GuidanceCounselor,id'],
            'firstName' => ['required', 'max:255'],
            'lastName' => ['required', 'max:255'],
            'phone' => ['required', 'max:255'],
            'stage_id' => ['required', 'max:255', 'exists:App\Models\Stage,id'],
        ], [], [])->validate();

        $guidanceCounselor = GuidanceCounselor::find($data['id']);
        if ($guidanceCounselor) {
            $guidanceCounselor->update([
                'first_name' => $data['firstName'],
                'last_name' => $data['lastName'],
                'phone' => $data['phone'],
                'stage_id' => $data['stage_id'],
            ]);

            return back()->with('success', trans('general.Account Updated Successfully'));
        } else {
            return back()->withErrors(trans('general.Account Not Found'));
        }
    }



    public function updatePassword(Request $request, $id)
    {
        // $this->authorize('update', GuidanceCounselor::class);
        $data = ($request->all());
        Validator::make($data, [
            'id' => ['required', 'max:255', 'exists:App\Models\GuidanceCounselor,id'],
            'password' => ['required', 'confirmed', Password::min(6)],
        ], [], [])->validate();

        $guidanceCounselor = GuidanceCounselor::find($data['id']);
        if ($guidanceCounselor) {
            $guidanceCounselor->update([
                'password' => Hash::make($data['password']),
            ]);

            return back()->with('success', trans('general.Account Updated Successfully'));
        } else {
            return back()->withErrors(trans('general.Account Not Found'));
        }
    }

    public function updateAccountStatus(Request $request, $id)
    {
        // $this->authorize('update', GuidanceCounselor::class);
        $data = ($request->all());
        Validator::make($data, [
            'id' => ['required', 'max:255', 'exists:App\Models\GuidanceCounselor,id'],
            'status' => ['required', Rule::in(['0', '1'])]
        ], [], [])->validate();

        $guidanceCounselor = GuidanceCounselor::find($data['id']);
        if ($guidanceCounselor) {

            $settings = json_decode($guidanceCounselor->settings);
            if (!$settings) {
                $settings = json_decode('{"status": "1"}');
            }
            $settings->status = $data['status'];

            $guidanceCounselor->update([
                'settings' => json_encode($settings),
            ]);
            return back()->with('success', trans('general.Account Updated Successfully'));
        } else {
            return back()->withErrors(trans('general.Account Not Found'));
        }
    }
}
