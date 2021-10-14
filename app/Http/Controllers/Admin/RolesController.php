<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\RolesDataTable;
use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RolesController extends Controller
{
    //

    public function roles(RolesDataTable $role)
    {
        $this->authorize('viewAny', Role::class);
        return ($role->render('admin.roles.roles-index'));
    }

    public function showCreateRoleView()
    {
        $this->authorize('create', Role::class);
        $permissions = Permission::all();
        $permissionsGroups = Permission::select('group')->distinct()->get();
        $permissionsAsGroups = [];
        foreach ($permissionsGroups as $group) {
            foreach ($permissions as $permission) {
                if ($group->group == $permission->group) {
                    $permissionsAsGroups[$group->group][] = $permission;
                }
            }
        }

        return view('admin.roles.roles-create', ['permissionsAsGroups' => $permissionsAsGroups]);
    }



    public function create(Request $request)
    {
        $this->authorize('create', Role::class);
        $data = ($request->all());
        Validator::make($data, [
            'title' => ['required', 'max:255'],
            'description' => ['required'],
            'permissions' => ['array'],
        ], [], [])->validate();


        DB::transaction(function () use ($data) {
            $id = Role::createGetId($data['title'], $data['description']);
            if (isset($data['permissions'])) {
                RolePermission::createMultiple($data['permissions'], $id);
            }
        });


        return back()->with('success', trans('general.role_created_successfully'));
    }

    public function delete(Request $request)
    {
        $this->authorize('delete', Role::class);
        $data = ($request->all());
        Validator::make($data, [
            'id' => ['required'],
        ], [], [])->validate();

        $role = Role::find($data['id']);


        if ($role) {
            (Role::destroy($role->id));
            return back()->with('success', trans('general.role_deleted_successfully'));
        } else {
            return back()->with('success', trans('general.record_not_found'));
        }
    }



    public function showUpdateForm($id)
    {
        // $this->authorize('view', Role::class);
        $role = Role::find($id);

        if ($role) {

            // $permissions = Permission::all();
            $role_permissions = Role::getRolePermissionsWithStatus($id);


            $permissionsGroups = Permission::select('group')->distinct()->get();
            $permissionsAsGroups = [];
            foreach ($permissionsGroups as $group) {
                foreach ($role_permissions as $permission) {
                    if ($group->group == $permission->group) {
                        $permissionsAsGroups[$group->group][] = $permission;
                    }
                }
            }
            // dd($permissionsAsGroups);
            return view('admin.roles.roles-edit', ['role' => $role, 'permissionsAsGroups' => $permissionsAsGroups]);
        } else {
            return back()->withErrors( trans('general.record_not_found'));
        }
    }



    public function update(Request $request)
    {
        // $this->authorize('update', Role::class);
        $data = ($request->all());
        Validator::make($data, [
            'id' => ['required'],
            'title' => ['required', 'max:255'],
            'description' => ['required'],
            'permissions' => ['array'],
        ], [], [])->validate();

        $role = Role::find($data['id']);


        if ($role) {


            $role_permissions = RolePermission::getRolePermissionIDs($role->id);
            if (isset($data['permissions'])) {
                $toAdd = array_diff($data['permissions'], $role_permissions); //added
                $toRemove = array_diff($role_permissions, $data['permissions']); //deleted

                RolePermission::createMultiple($toAdd, $role->id);

                RolePermission::where('role_id', $role->id)->whereIn('permission_id', $toRemove)->delete();

            } else {
                RolePermission::where('role_id', $role->id)->delete();
            }
            $role->title = $data['title'];            
            $role->description = $data['description'];
            $role->save();

            return back()->with('success', trans('general.role_updated_successfully'));
        } else {
            return back()->with('success', trans('general.record_not_found'));
        }
    }
}
