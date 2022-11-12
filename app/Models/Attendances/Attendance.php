<?php

namespace App\Models\Attendances;

use App\Models\AuthUser;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $table = 'attendances_attendance';

    protected $fillable = [
        'clock_in',
        'clock_out',
        'status',
        'timetable_id',
        'user_id',
    ];

    protected $casts = [
        'clock_in' => 'time',
        'clock_out' => 'time',
    ];

    public function user()
    {
        return $this->belongsTo(AuthUser::class, 'user_id');
    }

    public function timetable()
    {
        return $this->belongsTo(Timetable::class, 'timetable_id');
    }
}
