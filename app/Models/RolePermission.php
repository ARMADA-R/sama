<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RolePermission extends Model
{
    use HasFactory;

    public static function getRolePermissionIDs($id)
    {
        $res = DB::table('role_permissions')->select('permission_id')->where('role_id',$id)->get();
        $data = [];

        foreach ($res as $value) {
            $data[] = $value->permission_id;
        }
        return $data;
    }

    public static function createMultiple($permissions, $role_id)
    {
        $rolePermissions = [];
        foreach ($permissions as $value) {
            $rolePermissions[] = [
                'role_id' => $role_id,
                'permission_id' => $value,
                "created_at" =>  \Carbon\Carbon::now(),
                "updated_at" => \Carbon\Carbon::now(),
            ];
        }

        return DB::table('role_permissions')->insert($rolePermissions);
    }

    
}
