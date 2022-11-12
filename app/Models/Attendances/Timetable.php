<?php

namespace App\Models\Attendances;

use Illuminate\Database\Eloquent\Model;

class Timetable extends Model
{
    protected $table = 'attendances_attendancetimetable';

    protected $fillable = [
        'date',
        'work_time',
        'home_time',
        'role',
    ];

    protected $casts = [
        'date' => 'date',
        'work_time' => 'time',
        'home_time' => 'time',
    ];

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'timetable_id');
    }

    public function leaves()
    {
        return $this->hasMany(LeaveAttendance::class, 'attendancetimetable_id');
    }
}
