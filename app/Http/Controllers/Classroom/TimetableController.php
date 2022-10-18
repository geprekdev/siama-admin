<?php

namespace App\Http\Controllers\Classroom;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TimetableController extends Controller
{
    public function index(Request $request)
    {
        $subjects = DB::table('classrooms_classroomsubject')
            ->join('classrooms_classroom', 'classrooms_classroomsubject.classroom_id', '=', 'classrooms_classroom.id')
            ->select('classrooms_classroomsubject.id', 'classrooms_classroomsubject.name', 'classrooms_classroom.grade');

        $subjects->when($request->search, function ($query) use ($request) {
            $query->where('classrooms_classroomsubject.name', 'LIKE', "%{$request->search}%")
                ->orWhere('classrooms_classroom.grade', 'LIKE', "%{$request->search}%");
        });

        $timetables = DB::table('classrooms_classroomtimetable')
            ->joinSub($subjects, 'classrooms_classroomsubject', function ($join) {
                $join->on('classrooms_classroomtimetable.subject_id', '=', 'classrooms_classroomsubject.id');
            })
            ->select('classrooms_classroomtimetable.id', 'classrooms_classroomsubject.grade as class', 'classrooms_classroomsubject.name as subject', 'classrooms_classroomtimetable.date', 'classrooms_classroomtimetable.start_time', 'classrooms_classroomtimetable.end_time')
            ->latest('id')
            ->paginate(50);

        return view('classrooms.timetables.index', compact('timetables'));
    }
}
