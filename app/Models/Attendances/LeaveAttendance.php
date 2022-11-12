<?php

namespace App\Models\Attendances;

use Illuminate\Database\Eloquent\Model;

class LeaveAttendance extends Model
{
    protected $table = 'attendances_leave_attendance_scheduled';

    protected $fillable = [
        'leave_id',
        'attendancetimetable_id',
    ];

    public function timetable()
    {
        return $this->belongsTo(Timetable::class, 'attendancetimetable_id');
    }

    public function leave()
    {
        return $this->belongsTo(Leave::class, 'leave_id');
    }
}
