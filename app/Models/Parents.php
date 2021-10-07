<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Parents extends Model
{
    use HasFactory;

    public static function createAndGetId(array $data)
    {
        $newParentId = 2;
        DB::transaction(function () use ($data, &$newParentId) {

            $newParentId = DB::table('parents')->insertGetId([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'job' => $data['job'],
                'phone' => $data['phone'],
                'gender' => $data['gender'],
                "created_at" =>  \Carbon\Carbon::now(),
                "updated_at" => \Carbon\Carbon::now(),
            ]);


            $username =  strtolower(Str::random(8));
            $pass =  strtolower(Str::random(8));

            while (DeactivatedParentsAccount::where('username', $username)->exists()) {
                $username = strtolower(Str::random(8));
            }

            DeactivatedParentsAccount::create([
                'username' => $username,
                'password' => $pass,
                'parent_id' => $newParentId,
            ]);
        });

        return $newParentId;
    }
}
