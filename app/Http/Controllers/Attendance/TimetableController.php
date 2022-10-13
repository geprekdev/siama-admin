<?php

namespace App\Http\Controllers\Attendance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TimetableController extends Controller
{
    public function index(Request $request)
    {
        $timetables = DB::table('attendances_attendancetimetable');

        $timetables->when(!empty($request->date), function ($query) use ($request) {
            $query->where('date', $request->date);
        });

        $timetables = $timetables->latest('date')->paginate(50);

        return view('attendances.timetables.index', compact('timetables'));
    }
}
