<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentMonthlyExport implements FromView, WithHeadings
{
    use Exportable;

    public function __construct(private int $classroom_id, private int $month, private int $year)
    {
    }

    public function headings(): array
    {
        $grade = DB::table('classrooms_classroom')->where('id', $this->classroom_id)->first()->grade;
        $date = Carbon::parse($this->year . '-' . $this->month)->locale('id')->isoFormat('MMMM Y');

        return [
            ["Kelas $grade - $date"],
            ['#', 'Nama', 'Hadir', 'Terlambat'],
        ];
    }

    public function view(): View
    {
        $students = DB::table('classrooms_classroom_student')
            ->join('auth_user', 'classrooms_classroom_student.user_id', '=', 'auth_user.id')
            ->join('classrooms_classroom', 'classrooms_classroom_student.classroom_id', '=', 'classrooms_classroom.id')
            ->select('auth_user.id', 'auth_user.username as nis', 'auth_user.first_name as name', 'classrooms_classroom.grade')
            ->where('classrooms_classroom_student.classroom_id', $this->classroom_id);

        $attendances = DB::table('attendances_attendance')
            ->join('attendances_attendancetimetable', 'attendances_attendance.timetable_id', '=', 'attendances_attendancetimetable.id')
            ->joinSub($students, 'students', function ($join) {
                $join->on('students.id', '=', 'attendances_attendance.user_id');
            })
            ->select('attendances_attendance.id', 'students.name', 'students.grade', 'attendances_attendance.status')
            ->whereYear('attendances_attendancetimetable.date', '=', $this->year)
            ->whereMonth('attendances_attendancetimetable.date', '=', $this->month)
            ->get()
            ->groupBy(['name', 'status']);

        return view('exports.student-monthly', compact('attendances'));
    }
}
