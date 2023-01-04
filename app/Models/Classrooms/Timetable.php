<?php

namespace App\Models\Classrooms;

use App\Models\Attendances\LeaveClassroom;
use Illuminate\Database\Eloquent\Model;

class Timetable extends Model
{
    protected $table = 'classrooms_classroomtimetable';

    protected $fillable = [
        'token',
        'date',
        'start_time',
        'end_time',
        'subject_id',
        'grade',
    ];

    public $timestamps = false;

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'timetable_id');
    }

    public function journals()
    {
        return $this->hasMany(Journal::class, 'timetable_id');
    }

    public function leaves()
    {
        return $this->hasMany(LeaveClassroom::class, 'classroomtimetable_id');
    }
}
