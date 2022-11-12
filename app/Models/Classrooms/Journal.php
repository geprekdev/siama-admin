<?php

namespace App\Models\Classrooms;

use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    protected $table = 'classrooms_classroomjournal';

    protected $fillable = [
        'description',
        'subject_grade_id',
        'timetable_id',
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_grade_id');
    }

    public function timetable()
    {
        return $this->belongsTo(Timetable::class, 'timetable_id');
    }
}
