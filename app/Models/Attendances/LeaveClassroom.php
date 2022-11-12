<?php

namespace App\Models\Attendances;

use App\Models\Classrooms\Timetable;
use Illuminate\Database\Eloquent\Model;

class LeaveClassroom extends Model
{
    protected $table = 'attendances_leave_classroom_scheduled';

    protected $fillable = [
        'leave_id',
        'classroomtimetable_id',
    ];

    public function timetable()
    {
        return $this->belongsTo(Timetable::class, 'classroomtimetable_id');
    }

    public function leave()
    {
        return $this->belongsTo(Leave::class, 'leave_id');
    }
}
