<?php

namespace App\Http\Controllers\Recap;

use App\Exports\TeacherMonthlyExport;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeacherMonthlyController extends Controller
{
    public function index(Request $request)
    {
        // get months for select input on recap filter view
        $dates = DB::table('attendances_attendancetimetable')->selectRaw('MIN(date) as oldest, MAX(date) as newest')->first();
        $months = [];
        foreach (CarbonPeriod::create(Carbon::parse($dates->oldest)->startOfMonth(), '1 month', Carbon::parse($dates->newest)->startOfMonth()) as $month) {
            $months[$month->format('Y-m')] = $month->locale('id')->isoFormat('MMMM Y');
        }
        $months = array_reverse($months);

        return view('recaps.teacher-monthly', compact('months'));
    }

    public function export(Request $request)
    {
        $filter = $request->validate([
            'month' => ['required', 'string'],
        ]);

        $date = explode('-', $filter['month']);
        $fileDate = Carbon::parse($filter['month'])->locale('id')->isoFormat('MMMM Y');

        return (new TeacherMonthlyExport($date[1], $date[0]))->download("Rekap Kehadiran Guru - {$fileDate}.xlsx");
    }
}
