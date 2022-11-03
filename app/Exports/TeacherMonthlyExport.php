<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class TeacherMonthlyExport implements FromView, ShouldAutoSize
{
    use Exportable;

    public function __construct(private int $month, private int $year)
    {
    }

    public function view(): View
    {
        $teachers = DB::table('auth_user_groups')
            ->join('auth_user', 'auth_user_groups.user_id', '=', 'auth_user.id')
            ->join('auth_group', 'auth_user_groups.group_id', '=', 'auth_group.id')
            ->select('auth_user.id', 'auth_user.username', 'auth_user.first_name as name')
            ->whereIn('auth_group.name', ['teacher', 'staff']);

        $attendances = DB::table('attendances_attendance')
            ->join('attendances_attendancetimetable', 'attendances_attendance.timetable_id', '=', 'attendances_attendancetimetable.id')
            ->joinSub($teachers, 'teachers', function ($join) {
                $join->on('teachers.id', '=', 'attendances_attendance.user_id');
            })
            ->select('attendances_attendance.id', 'teachers.username', 'teachers.name', 'attendances_attendance.status')
            ->whereYear('attendances_attendancetimetable.date', '=', $this->year)
            ->whereMonth('attendances_attendancetimetable.date', '=', $this->month)
            ->get()
            ->groupBy(['name', 'status']);

        $date = Carbon::parse($this->year . '-' . $this->month)->locale('id')->isoFormat('MMMM Y');

        return view('exports.teacher-monthly', compact('attendances', 'date'));
    }
}
