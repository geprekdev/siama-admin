<?php

namespace App\Models\Classrooms;

use App\Models\AuthUser;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    protected $table = 'classrooms_classroom';

    protected $fillable = [
        'grade',
        'homeroom_teacher_id',
    ];

    public function homeroomTeacher()
    {
        return $this->belongsTo(AuthUser::class, 'homeroom_teacher_id');
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class, 'classroom_id');
    }
}
