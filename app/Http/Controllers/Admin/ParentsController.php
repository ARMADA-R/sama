<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ParentsDataTable;
use App\DataTables\DeactivatedParentsAccountsDataTable;
use App\Exports\DeactivatedParentsAccounts;
use App\Http\Controllers\Controller;
use App\Models\ParentAccount;
use App\Models\Parents;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Maatwebsite\Excel\Facades\Excel;

class ParentsController extends Controller
{
    //
    public function parents(ParentsDataTable $parentsDataTable)
    {
        return ($parentsDataTable->render('admin.parents.parents-index'));
    }


    public function deactivatedParents(DeactivatedParentsAccountsDataTable $deactivatedParentsAccountsDataTable)
    {
        return ($deactivatedParentsAccountsDataTable->render('admin.parents.parents-deactivated'));
    }



    public function deactivatedParentsExcel()
    {
        return Excel::download(new DeactivatedParentsAccounts, trans('parents_deactivated_accounts') . '-' . date('YmdHis') . '.xlsx');

        // return ($deactivatedParentsAccountsDataTable->render('admin.parents.parents-deactivated'));
    }



    public function mothersSearch(Request $request)
    {
        $key = $request->input('key');
        if ($key) {
            $res = Parents::where('gender', '=', 'female')
                ->where(function ($query) use ($key) {
                    $query->where('last_name', 'LIKE', '%' . $key . '%');
                    $query->orWhere('first_name', 'LIKE', '%' . $key . '%');
                    $query->orWhere('phone', 'LIKE', '%' . $key . '%');
                })
                ->get()->toArray();

            if (!empty($res)) {

                return $data = [
                    "code" => 1,
                    "data" => $res,
                    "msg" => ""
                ];
                return response($data, 200);
            }
        }

        $data = [
            "code" => -1,
            "data" => [],
            "msg" => "no results found"
        ];

        return response($data, 400);
    }



    public function fathersSearch(Request $request)
    {
        $key = $request->input('key');
        if ($key) {
            $res = Parents::where('gender', '=', 'male')
                ->where(function ($query) use ($key) {
                    $query->where('last_name', 'LIKE', '%' . $key . '%');
                    $query->orWhere('first_name', 'LIKE', '%' . $key . '%');
                    $query->orWhere('phone', 'LIKE', '%' . $key . '%');
                })
                ->get()->toArray();

            if (!empty($res)) {

                $data = [
                    "code" => 1,
                    "data" => $res,
                    "msg" => ""
                ];

                return response($data, 200);
            }
        }

        $data = [
            "code" => -1,
            "data" => [],
            "msg" => "no results found"
        ];

        return response($data, 400);
    }


    public function showCreateParentView()
    {
        return view('admin.parents.parents-create');
    }

    public function create(Request $request)
    {
        $data = $request->all();
        Validator::make($data, [
            'firstName' => ['required', 'max:190'],
            'lastName' => ['required', 'max:190'],
            'job' => ['required', 'max:190'],
            'gender' => ['required', 'max:190'],
            'phone' => ['required', 'max:190', 'unique:App\Models\Parents,phone',],
        ], [], [])->validate();

        Parents::createAndGetId([
            'first_name' => $data['firstName'],
            'last_name' => $data['lastName'],
            'job' => $data['job'],
            'phone' => $data['phone'],
            'gender' => $data['gender'],
        ]);

        return back()->with('success', trans('general.New parent added Successfully'));
    }


    public function showUpdateParentView($id)
    {
        $parent = Parents::find($id);
        $parentAccount = ParentAccount::where('parent_id', $id)->first();
        if ($parent) {
            return view('admin.parents.parents-edit', ['parent' => $parent, 'parentAccount' => $parentAccount]);
        } else {
            return back()->withErrors(trans('general.record_not_found'));
        }
    }

    public function update(Request $request)
    {
        $data = $request->all();
        Validator::make($data, [
            'id' => ['required', 'max:190', 'exists:App\Models\Parents,id'],
            'firstName' => ['required', 'max:190'],
            'lastName' => ['required', 'max:190'],
            'job' => ['required', 'max:190'],
            'gender' => ['required', 'max:190'],
            'phone' => ['required', 'max:190', 'unique:App\Models\Parents,phone,' . $data['id'],],
        ], [], [])->validate();

        $parent = Parents::find($data['id']);
        $parent->first_name = $data['firstName'];
        $parent->last_name = $data['lastName'];
        $parent->job = $data['job'];
        $parent->phone = $data['phone'];
        $parent->gender = $data['gender'];
        $parent->save();

        return back()->with('success', trans('general.parent_updated_successfully'));
    }


    public function updateAccount(Request $request)
    {
        $data = $request->all();
        Validator::make($data, [
            'id' => ['required', 'max:190', 'exists:App\Models\ParentAccount,id'],
            'password' => ['required', 'confirmed', Password::min(7)],
        ], [], [])->validate();

        $parent = ParentAccount::find($data['id']);

        $parent->password = Hash::make($data['password']);
        $parent->save();

        return back()->with('success', trans('general.parent_updated_successfully'));
    }


    public function delete(Request $request)
    {
        $data = $request->all();
        Validator::make($data, [
            'parent_id' => ['required', 'max:190', 'exists:App\Models\Parents,id'],
        ], [], [])->validate();

        $parent = Parents::find($data['parent_id']);

        try {
            $parent->delete();
            return back()->with('success', trans('general.parent_delete_successfully'));

        } catch (\Illuminate\Database\QueryException $th) {
            return back()->withErrors(trans('general.record_foreign_key_delete_error'));
            
        } catch (\Throwable $th) {
            return back()->withErrors(trans('general.record_delete_error'));
        }
    }
}
