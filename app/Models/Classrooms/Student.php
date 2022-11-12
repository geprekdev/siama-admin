<?php

namespace App\Models\Classrooms;

use App\Models\AuthUser;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'classrooms_classroom_student';

    protected $fillable = [
        'classroom_id',
        'user_id',
    ];

    public function information()
    {
        return $this->belongsTo(AuthUser::class, 'user_id');
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class, 'classroom_id');
    }
}
