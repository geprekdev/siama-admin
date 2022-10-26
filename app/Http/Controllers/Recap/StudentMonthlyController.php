<?php

namespace App\Http\Controllers\Recap;

use App\Exports\StudentMonthlyExport;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentMonthlyController extends Controller
{
    public function index(Request $request)
    {
        $classrooms = DB::table('classrooms_classroom')
            ->select('id', 'grade')
            ->orderBy('grade')
            ->get();

        // get months for select input on recap filter view
        $dates = DB::table('attendances_attendancetimetable')->selectRaw('MIN(date) as oldest, MAX(date) as newest')->first();
        $months = [];
        foreach (CarbonPeriod::create(Carbon::parse($dates->oldest)->startOfMonth(), '1 month', Carbon::parse($dates->newest)->startOfMonth()) as $month) {
            $months[$month->format('Y-m')] = $month->locale('id')->isoFormat('MMMM Y');
        }
        $months = array_reverse($months);

        return view('recaps.student-monthly', compact('classrooms', 'months'));
    }

    public function export(Request $request)
    {
        $filter = $request->validate([
            'classroom_id' => ['required', 'numeric'],
            'month' => ['required', 'string'],
        ]);

        $grade = DB::table('classrooms_classroom')->where('id', $filter['classroom_id'])->first()->grade;
        $date = explode('-', $filter['month']);
        $fileDate = Carbon::parse($filter['month'])->locale('id')->isoFormat('MMMM Y');

        return (new StudentMonthlyExport($filter['classroom_id'], $date[1], $date[0]))->download("Rekap Kehadiran {$grade} - {$fileDate}.xlsx");
    }
}
