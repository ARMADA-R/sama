<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\UsersDataTable;
use App\DataTables\UsersPermissionsDataTable;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UsersController extends Controller
{
    public function users(UsersDataTable $user)
    {
        $this->authorize('viewAny', User::class);
        return ($user->render('admin.users.users-index'));
    }


    public function showCreateAdminView()
    {
        $roles = Role::all();
        return view('admin.users.users-create', ['roles' => $roles]);
    }

    public function create(Request $request)
    {
        $this->authorize('create', User::class);
        $data = ($request->all());
        Validator::make($data, [
            'firstName' => ['required', 'max:255'],
            'lastName' => ['required', 'max:255'],
            'email' => ['required', 'unique:users', 'max:255', 'email'],
            'role' => ['required'],
            'username' => ['required', 'max:255'],
            'password' => ['required', 'confirmed', Password::min(4)],
        ], [], [])->validate();

        User::create([
            'first_name' => $data['firstName'],
            'last_name' => $data['lastName'],
            'email' => $data['email'],
            'role_id' => $data['role'],
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
            'settings' => ('{"status": "1"}'),
        ]);

        return back()->with('success', trans('general.New Account Created Successfully'));
    }


    public function showUpdateAdminView($id)
    {
        $this->authorize('view', User::class);
        $roles = Role::all();
        $user = User::find($id);
        return view('admin.users.users-edit', ['roles' => $roles, 'user' => $user]);
    }

    public function update(Request $request, $id)
    {
        $this->authorize('update', User::class);
        $data = ($request->all());
        Validator::make($data, [
            'firstName' => ['required', 'max:255'],
            'lastName' => ['required', 'max:255'],
            'role' => ['required'],
        ], [], [])->validate();

        $user = User::find($id);
        if ($user) {

            $user->update([
                'first_name' => $data['firstName'],
                'last_name' => $data['lastName'],
                'role_id' => $data['role'],
            ]);

            return back()->with('success', trans('general.Account Updated Successfully'));

        } else {
            return back()->withErrors(trans('general.Account Not Found'));
        }
        

        
    }


    public function updatePassword(Request $request, $id)
    {
        $this->authorize('update', User::class);
        $data = ($request->all());
        Validator::make($data, [
            'password' => ['required', 'confirmed', Password::min(4)],
        ], [], [])->validate();

        $user = User::find($id);
        if ($user) {

            $user->update([
                'password' => Hash::make($data['password']),
            ]);

            return back()->with('success', trans('general.Account Updated Successfully'));

        } else {
            return back()->withErrors(trans('general.Account Not Found'));
        }
        
    }

    public function updateAccountStatus(Request $request, $id)
    {
        $this->authorize('update', User::class);
        $data = ($request->all());
        Validator::make($data, [
            'status' => ['required', Rule::in(['0', '1'])]
        ], [], [])->validate();

        $user = User::find($id);
        if ($user) {

            $settings = json_decode($user->settings);
            $settings->status = $data['status'];
        
            $user->update([
                'settings' => json_encode($settings),
            ]);
            return back()->with('success', trans('general.Account Updated Successfully'));

        } else {
            return back()->withErrors(trans('general.Account Not Found'));
        }
        
    }



    public function getUserPermissions(UsersPermissionsDataTable $dataTable, $id)
    {
        $roles = Role::all();
        $user = User::find($id);
        return $dataTable->with('id', $id)
        ->render('admin.users.users-edit', ['roles' => $roles, 'user' => $user]);
        // return view('admin.users.users-edit', ['roles' => $roles, 'user' => $user]);
    }


    public function setUserPermissions(Request $request)
    {
        dd($request);
    }


}
