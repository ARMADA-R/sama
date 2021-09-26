<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Role extends Model
{
    use HasFactory;


    public static function getRolePermissionsWithStatus($role_id)
    {
        return DB::table('permissions')->select(['permissions.*', 'role_permissions.id as status_id'])
            ->leftJoin('role_permissions', function ($join) use ($role_id) {
                $join->on('permissions.id', '=', 'role_permissions.permission_id')
                    ->where('role_permissions.role_id', '=', $role_id);
            })->get();
    }

    public function getRolePermissionsAsCodesArray()
    {
        $rolePermissions = DB::table('permissions')->select(['permissions.*'])
            ->join('role_permissions', function ($join) {
                $join->on('permissions.id', '=', 'role_permissions.permission_id')
                    ->where('role_permissions.role_id', '=', $this->id);
            })->get();
        $permissionsCodes = [];

        foreach ($rolePermissions as $value) {
            $permissionsCodes[] = $value->code;
        }

        return $permissionsCodes;
    }


    public static function createGetId($title, $description)
    {
        return DB::table('roles')->insertGetId([
            'title' => $title,
            'description' => $description,
            "created_at" =>  \Carbon\Carbon::now(),
            "updated_at" => \Carbon\Carbon::now(),
        ]);
    }
}
