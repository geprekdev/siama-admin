<?php

namespace App\Models\Classrooms;

use App\Models\AuthUser;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $table = 'classrooms_classroomattendance';

    protected $fillable = [
        'status',
        'student_id',
        'timetable_id',
        'token',
    ];

    public function student()
    {
        return $this->belongsTo(AuthUser::class, 'student_id');
    }

    public function timetable()
    {
        return $this->belongsTo(Timetable::class, 'timetable_id');
    }
}
