<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentLevels extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'school',
        'status',
        'year',
        'level_id',
        'student_id',
    ];

    public function getSequenceWhereNotIn(array $data)
    {
        foreach ($data as $key => $value) {
            
        }
    }

}
