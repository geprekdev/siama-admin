<?php

namespace App\Models\Attendances;

use App\Models\AuthUser;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    protected $table = 'attendances_leave';

    protected $fillable = [
        'leave_mode',
        'leave_type',
        'reason',
        'attachment',
        'approve',
        'user_id',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(AuthUser::class, 'user_id');
    }

    public function attendance()
    {
        return $this->hasOne(LeaveAttendance::class, 'leave_id');
    }

    public function classroom()
    {
        return $this->hasOne(LeaveClassroom::class, 'leave_id');
    }
}
