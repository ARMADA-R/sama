<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ParentsDataTable;
use App\DataTables\DeactivatedParentsAccountsDataTable;
use App\Exports\DeactivatedParentsAccounts;
use App\Http\Controllers\Controller;
use App\Models\Parents;
use Illuminate\Http\Request;
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
        return Excel::download(new DeactivatedParentsAccounts, trans('parents_deactivated_accounts').'-'.date('YmdHis').'.xlsx');

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



}
