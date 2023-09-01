<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ClassroomController extends Controller
{
    public function index(Request $request): View
    {
        $classrooms = DB::table('classrooms_classroom')
            ->select('classrooms_classroom.id', 'classrooms_classroom.grade', 'auth_user.id as teacher_id', 'auth_user.first_name as teacher_name')
            ->join('auth_user', 'classrooms_classroom.homeroom_teacher_id', '=', 'auth_user.id');

        $classrooms->when($request->has('search'), function (Builder $query) use ($request) {
            $query->where('classrooms_classroom.grade', 'LIKE', "%{$request->get('search')}%")
                ->orWhere('auth_user.first_name', 'LIKE', "%{$request->get('search')}%");
        });

        $classrooms = $classrooms->orderBy('classrooms_classroom.grade')->paginate(25);

        return view('classrooms.classrooms.index')
            ->with(['classrooms' => $classrooms]);
    }

    public function create(): View
    {
        $teachers = DB::table('auth_user_groups')
            ->join('auth_user', 'auth_user_groups.user_id', '=', 'auth_user.id')
            ->join('auth_group', 'auth_user_groups.group_id', '=', 'auth_group.id')
            ->select('auth_user.id', 'auth_user_groups.group_id', 'auth_user.first_name')
            ->where('auth_user_groups.group_id', 1)
            ->latest('auth_user.id')
            ->get();

        return view('classrooms.classrooms.create')->with(['teachers' => $teachers]);
    }

    public function store(Request $request): RedirectResponse
    {
        $teachers = DB::table('auth_user_groups')
            ->join('auth_user', 'auth_user_groups.user_id', '=', 'auth_user.id')
            ->join('auth_group', 'auth_user_groups.group_id', '=', 'auth_group.id')
            ->select('auth_user.id', 'auth_user_groups.group_id', 'auth_user.first_name')
            ->where('auth_user_groups.group_id', 1)
            ->pluck('auth_user.id')
            ->toArray();

        $data = $request->validate([
            'grade' => ['required', 'string', 'max:255', Rule::unique('classrooms_classroom', 'grade')],
            'homeroom_teacher_id' => ['required', 'string', 'max:255', Rule::in($teachers)]
        ]);

        DB::table('classrooms_classroom')->insert($data);

        return redirect()->route('classrooms.index')
            ->with('success', 'Berhasil menambah kelas');
    }

    public function edit(int $id): View
    {
        $classroom = DB::table('classrooms_classroom')
            ->select('classrooms_classroom.id', 'classrooms_classroom.grade', 'auth_user.id as teacher_id', 'auth_user.first_name as teacher_name')
            ->join('auth_user', 'classrooms_classroom.homeroom_teacher_id', '=', 'auth_user.id')
            ->where('classrooms_classroom.id', $id)
            ->first();

        abort_if(is_null($classroom), 404);

        $students = DB::table('classrooms_classroom_student')
            ->select('auth_user.id', 'auth_user.first_name')
            ->join('auth_user', 'classrooms_classroom_student.user_id', '=', 'auth_user.id')
            ->where('classrooms_classroom_student.classroom_id', $classroom->id)
            ->orderBy('auth_user.first_name')
            ->get();

        $teachers = DB::table('auth_user_groups')
            ->join('auth_user', 'auth_user_groups.user_id', '=', 'auth_user.id')
            ->join('auth_group', 'auth_user_groups.group_id', '=', 'auth_group.id')
            ->select('auth_user.id', 'auth_user_groups.group_id', 'auth_user.first_name')
            ->where('auth_user_groups.group_id', 1)
            ->latest('auth_user.id')
            ->get();

        return view('classrooms.classrooms.edit')
            ->with(['classroom' => $classroom, 'students' => $students, 'teachers' => $teachers]);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $teachers = DB::table('auth_user_groups')
            ->join('auth_user', 'auth_user_groups.user_id', '=', 'auth_user.id')
            ->join('auth_group', 'auth_user_groups.group_id', '=', 'auth_group.id')
            ->select('auth_user.id', 'auth_user_groups.group_id', 'auth_user.first_name')
            ->where('auth_user_groups.group_id', 1)
            ->pluck('auth_user.id')
            ->toArray();

        $data = $request->validate([
            'grade' => ['required', 'string', 'max:255', Rule::unique('classrooms_classroom', 'grade')->ignore($request->route('classroom'))],
            'homeroom_teacher_id' => ['required', 'string', 'max:255', Rule::in($teachers)],
        ]);

        DB::table('classrooms_classroom')
            ->where('id', $id)
            ->update($data);

        return redirect()->route('classrooms.index')
            ->with('success', 'Berhasil mengedit kelas');
    }

    public function destroy(int $id): RedirectResponse
    {
        DB::table('classrooms_classroom_student')->where('classroom_id')->delete();
        DB::table('classrooms_classroom')->where('id', $id)->delete();

        return redirect()->route('classrooms.index')
            ->with('success', 'Berhasil menghapus kelas');
    }
}
