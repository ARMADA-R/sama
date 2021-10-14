<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\HeadmastersDataTable;
use App\Http\Controllers\Controller;
use App\Models\Headmaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class HeadmastersController extends Controller
{
    //
    public function headmasters(HeadmastersDataTable $headmastersDataTable)
    {
        // $this->authorize('viewAny', Headmaster::class);
        return ($headmastersDataTable->render('admin.headmasters.headmasters-index'));
    }


    public function showCreateView()
    {
        return view('admin.headmasters.headmasters-create');
    }
    
    public function create(Request $request)
    {
        // $this->authorize('create', Headmaster::class);
        $data = ($request->all());
        Validator::make($data, [
            'firstName' => ['required', 'max:255'],
            'lastName' => ['required', 'max:255'],
            'email' => ['required', 'unique:headmasters', 'max:255', 'email'],
            'phone' => ['required'],
            'username' => ['required', 'max:255'],
            'password' => ['required', Password::min(6)],
        ], [], [])->validate();

        Headmaster::create([
            'first_name' => $data['firstName'],
            'last_name' => $data['lastName'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
            'settings' => ('{"status": "1"}'),
        ]);

        return back()->with('success', trans('general.headmaster_account_created'));
    }


    

    public function showUpdateView($id)
    {
        Validator::make(['id' => $id], [
            'id' => ['required', 'max:255', 'exists:App\Models\Headmaster,id'],
        ], [], [])->validate();
        // $this->authorize('view', Headmaster::class);
        $headmaster = Headmaster::find($id);
        return view('admin.headmasters.headmasters-edit', ['headmaster' => $headmaster]);
    }

    public function update(Request $request, $id)
    {
        // $this->authorize('update', Headmaster::class);
        $data = ($request->all());
        Validator::make($data, [
            'id' => ['required', 'max:255', 'exists:App\Models\Headmaster,id'],
            'firstName' => ['required', 'max:255'],
            'lastName' => ['required', 'max:255'],
            'phone' => ['required', 'max:255'],
        ], [], [])->validate();

        $headmaster = Headmaster::find($data['id']);
        if ($headmaster) {
            $headmaster->update([
                'first_name' => $data['firstName'],
                'last_name' => $data['lastName'],
                'phone' => $data['phone'],
            ]);

            return back()->with('success', trans('general.Account Updated Successfully'));

        } else {
            return back()->withErrors(trans('general.Account Not Found'));
        }
        
    }


    
    public function updatePassword(Request $request, $id)
    {
        // $this->authorize('update', Headmaster::class);
        $data = ($request->all());
        Validator::make($data, [
            'id' => ['required', 'max:255', 'exists:App\Models\Headmaster,id'],
            'password' => ['required', 'confirmed', Password::min(6)],
        ], [], [])->validate();

        $headmaster = Headmaster::find($data['id']);
        if ($headmaster) {
            $headmaster->update([
                'password' => Hash::make($data['password']),
            ]);

            return back()->with('success', trans('general.Account Updated Successfully'));

        } else {
            return back()->withErrors(trans('general.Account Not Found'));
        }
        
    }

    public function updateAccountStatus(Request $request, $id)
    {
        // $this->authorize('update', Headmaster::class);
        $data = ($request->all());
        Validator::make($data, [
            'id' => ['required', 'max:255', 'exists:App\Models\Headmaster,id'],
            'status' => ['required', Rule::in(['0', '1'])]
        ], [], [])->validate();

        $headmaster = Headmaster::find($data['id']);
        if ($headmaster) {

            $settings = json_decode($headmaster->settings);
            if (!$settings) {
                $settings = json_decode('{"status": "1"}');
            }
            $settings->status = $data['status'];
            
            $headmaster->update([
                'settings' => json_encode($settings),
            ]);
            return back()->with('success', trans('general.Account Updated Successfully'));

        } else {
            return back()->withErrors(trans('general.Account Not Found'));
        }
        
    }



    
}
