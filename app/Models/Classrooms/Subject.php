<?php

namespace App\Models\Classrooms;

use App\Models\AuthUser;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $table = 'classrooms_classroomsubject';

    protected $fillable = [
        'name',
        'classroom_id',
        'teacher_id',
        'slug',
    ];

    public function teacher()
    {
        return $this->belongsTo(AuthUser::class, 'teacher_id');
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class, 'classroom_id');
    }

    public function timetables()
    {
        return $this->hasMany(Timetable::class, 'subject_id');
    }

    public function journals()
    {
        return $this->hasMany(Journal::class, 'subject_grade_id');
    }
}
