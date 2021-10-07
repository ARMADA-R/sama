<?php

namespace App\Exports;

use App\Models\DeactivatedParentsAccount;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;

class DeactivatedParentsAccounts implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {

        return DeactivatedParentsAccount::select(
            DB::raw("CONCAT(students.first_name,' ',students.last_name) as 'student'"),
            DB::raw("CONCAT(parents.first_name,' ',parents.last_name) as 'Parent'"),
            'deactivated_parents_accounts.username',
            'deactivated_parents_accounts.password'
        )
            ->join('parents', 'parents.id', '=', 'deactivated_parents_accounts.parent_id')
            ->join('students', function ($join) {
                $join->on('parents.id', '=', 'students.father_id')->orOn('parents.id', '=', 'students.mother_id');
            })->get();
    }
}
