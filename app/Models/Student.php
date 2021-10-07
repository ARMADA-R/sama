<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Student extends Model
{
    use HasFactory;

    public static function createAndGetId(array $data)
    {
        return DB::table('students')->insertGetId([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'birth_date' => \Carbon\Carbon::create($data['birth_date']),
            'birth_place' => $data['birth_place'],
            'gender' => $data['gender'],
            'city_id' => $data['city_id'],
            'street' => $data['street'],
            'area' => $data['area'],
            'phone' => $data['phone'],
            'telephone' => $data['telephone'],
            'emergency_phone' => $data['emergency_phone'],
            'emergency_kinship' => $data['emergency_kinship'],
            'religion_id' => $data['religion_id'],
            'mother_id' => $data['mother_id'],
            'father_id' => $data['father_id'],
            'division_id' => $data['division_id'],
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
    }
}
