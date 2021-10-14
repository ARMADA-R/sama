<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Division extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'title',
        'code',
        'capacity',
        'level_id',
    ];

    public static function getDivisionStudentsByLevelId($level)
    {
        return DB::table('divisions')->select('divisions.id', 'divisions.capacity', DB::raw('COUNT(students.id) AS students'))
        ->leftJoin('students', 'students.division_id', '=', 'divisions.id')
        ->where('divisions.level_id', $level)
        ->groupBy('divisions.id')->get();
    }
}
