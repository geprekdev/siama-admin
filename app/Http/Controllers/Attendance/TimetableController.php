<?php

namespace App\Http\Controllers\Attendance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

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

    public function create()
    {
        return view('attendances.timetables.create');
    }

    public function store(Request $request)
    {
        $timetable = $request->validate([
            'date' => ['required', 'date'],
            'work_time' => ['required', 'date_format:H:i'],
            'home_time' => ['required', 'date_format:H:i'],
            'role' => ['required', Rule::in(['MRD', 'GRU', 'KWN'])],
        ]);

        DB::table('attendances_attendancetimetable')->insert($timetable);

        return redirect()->route('attendances.timetables.index')->with('success', 'Berhasil menambah jadwal');
    }

    public function edit($id)
    {
        $timetable = DB::table('attendances_attendancetimetable')->where('id', $id)->first();

        return view('attendances.timetables.edit', compact('timetable'));
    }

    public function update(Request $request, $id)
    {
        $timetable = $request->validate([
            'date' => ['required', 'date'],
            'work_time' => ['required', 'date_format:H:i'],
            'home_time' => ['required', 'date_format:H:i'],
            'role' => ['required', Rule::in(['MRD', 'GRU', 'KWN'])],
        ]);

        DB::table('attendances_attendancetimetable')
            ->where('id', $id)
            ->update($timetable);

        return redirect()
            ->route('attendances.timetables.index')
            ->with('success', 'Berhasil mengedit jadwal');
    }

    public function destroy($id)
    {
        DB::table('attendances_attendancetimetable')->delete($id);

        return redirect()
            ->route('attendances.timetables.index')
            ->with('success', 'Berhasil menghapus jadwal');
    }
}
