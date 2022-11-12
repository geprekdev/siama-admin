<?php

namespace App\Models;

use App\Models\Attendances;
use App\Models\Classrooms;
use Illuminate\Database\Eloquent\Model;

class AuthUser extends Model
{
    protected $table = 'auth_user';

    protected $fillable = [
        'password',
        'is_superuser',
        'username',
        'first_name',
        'last_name',
        'email',
        'is_staff',
        'is_active',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'last_login' => 'datetime',
        'date_joined' => 'datetime',
    ];

    public function group()
    {
        return $this->hasMany(AuthUserGroup::class, 'user_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendances\Attendance::class, 'user_id');
    }

    public function leaves()
    {
        return $this->hasMany(Attendances\Leave::class, 'user_id');
    }

    public function classroomAttendances()
    {
        return $this->hasMany(Classrooms\Attendance::class, 'student_id');
    }

    public function classrooms()
    {
        return $this->hasMany(Classrooms\Student::class, 'user_id');
    }

    public function homerooms()
    {
        return $this->hasMany(Classrooms\Classroom::class, 'homeroom_teacher_id');
    }

    public function subjects()
    {
        return $this->hasMany(Classrooms\Subject::class, 'teacher_id');
    }
}
