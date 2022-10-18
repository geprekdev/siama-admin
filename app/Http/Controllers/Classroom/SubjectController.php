<?php

namespace App\Http\Controllers\Classroom;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubjectController extends Controller
{
    public function index(Request $request)
    {
        $teachers = DB::table('auth_user_groups')
            ->join('auth_user', 'auth_user_groups.user_id', '=', 'auth_user.id')
            ->join('auth_group', 'auth_user_groups.group_id', '=', 'auth_group.id')
            ->select('auth_user_groups.group_id', 'auth_user.id', 'auth_user.first_name')
            ->where('auth_user_groups.group_id', 1);

        $subjects = DB::table('classrooms_classroomsubject')
            ->join('classrooms_classroom', 'classrooms_classroomsubject.classroom_id', '=', 'classrooms_classroom.id')
            ->joinSub($teachers, 'teachers', function ($join) {
                $join->on('classrooms_classroomsubject.teacher_id', '=', 'teachers.id');
            })
            ->select('classrooms_classroomsubject.id', 'classrooms_classroomsubject.name', 'classrooms_classroom.grade as class', 'teachers.first_name as teacher');

        $subjects->when($request->search, function ($query) use ($request) {
            $query->where('classrooms_classroomsubject.name', 'LIKE', "%{$request->search}%")
                ->orWhere('classrooms_classroom.grade', 'LIKE', "%{$request->search}%")
                ->orWhere('teachers.first_name', 'LIKE', "%{$request->search}%");
        });

        $subjects = $subjects->latest('classrooms_classroomsubject.id')->paginate(50);

        return view('classrooms.subjects.index', compact('subjects'));
    }

    public function create()
    {
        $teachers = DB::table('auth_user_groups')
            ->join('auth_user', 'auth_user_groups.user_id', '=', 'auth_user.id')
            ->join('auth_group', 'auth_user_groups.group_id', '=', 'auth_group.id')
            ->select('auth_user.id', 'auth_user_groups.group_id', 'auth_user.first_name as name')
            ->where('auth_user_groups.group_id', 1)
            ->latest('auth_user.id')
            ->get();

        $classrooms = DB::table('classrooms_classroom')
            ->select('id', 'grade')
            ->latest('id')
            ->get();

        return view('classrooms.subjects.create', compact('teachers', 'classrooms'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'classroom_id' => ['required', 'numeric'],
            'teacher_id' => ['required', 'numeric'],
        ]);

        $data['slug'] = "{$data['name']}-{$data['classroom_id']}-{$data['teacher_id']}";

        DB::table('classrooms_classroomsubject')->insert($data);

        return redirect()->route('classrooms.subjects.index')->with('success', 'Berhasil menambah mata pelajaran');
    }

    public function edit($id)
    {
        $teachers = DB::table('auth_user_groups')
            ->join('auth_user', 'auth_user_groups.user_id', '=', 'auth_user.id')
            ->join('auth_group', 'auth_user_groups.group_id', '=', 'auth_group.id')
            ->select('auth_user.id', 'auth_user_groups.group_id', 'auth_user.first_name as name')
            ->where('auth_user_groups.group_id', 1)
            ->latest('auth_user.id')
            ->get();

        $classrooms = DB::table('classrooms_classroom')
            ->select('id', 'grade')
            ->latest('id')
            ->get();

        $subject = DB::table('classrooms_classroomsubject')->where('id', $id)->first();

        return view('classrooms.subjects.edit', compact('subject', 'teachers', 'classrooms'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'classroom_id' => ['required', 'numeric'],
            'teacher_id' => ['required', 'numeric'],
        ]);

        $data['slug'] = "{$data['name']}-{$data['classroom_id']}-{$data['teacher_id']}";

        DB::table('classrooms_classroomsubject')
            ->where('id', $id)
            ->update($data);

        return redirect()->route('classrooms.subjects.index')->with('success', 'Berhasil mengedit mata pelajaran');
    }

    public function destroy($id)
    {
        DB::table('classrooms_classroomsubject')->delete($id);

        return redirect()
            ->route('classrooms.subjects.index')
            ->with('success', 'Berhasil menghapus mata pelajaran');
    }
}
