<?php

namespace App\Http\Controllers\Attendance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LeaveFullDayController extends Controller
{
    public function index(Request $request)
    {
        $leaves = DB::table('attendances_leave')
            ->join('auth_user', 'attendances_leave.user_id', '=', 'auth_user.id')
            ->select('attendances_leave.id', 'auth_user.first_name as name', 'attendances_leave.approve', 'attendances_leave.leave_type', 'attendances_leave.created_at')
            ->where('attendances_leave.leave_mode', 1);

        $leaves->when($request->search, function ($query) use ($request) {
            $query->where('auth_user.first_name', 'LIKE', "%{$request->search}%");
        });

        $leaves->when($request->approve, function ($query) use ($request) {
            $approve = match ($request->approve) {
                'ditolak' => 0,
                'diterima' => 1,
                'menunggu' => null,
            };
            $query->where('attendances_leave.approve', $approve);
        });

        $leaves->when($request->category, function ($query) use ($request) {
            $category = match ($request->category) {
                'izin' => 0,
                'sakit' => 1,
                'sekolah' => 2,
            };
            $query->where('attendances_leave.leave_type', $category);
        });

        $leaves->when($request->date, function ($query) use ($request) {
            $query->whereDate('attendances_leave.created_at', $request->date);
        });

        $leaves = $leaves->latest('created_at')->paginate(50);

        return view('attendances.leaves.full-days.index', compact('leaves'));
    }
}
