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

    public function edit($id)
    {
        $leave = DB::table('attendances_leave')
            ->join('auth_user', 'attendances_leave.user_id', '=', 'auth_user.id')
            ->select('attendances_leave.id', 'auth_user.first_name as name', 'attendances_leave.leave_type', 'attendances_leave.reason', 'attendances_leave.attachment', 'attendances_leave.created_at', 'attendances_leave.approve')
            ->where('attendances_leave.id', $id)
            ->first();

        return view('attendances.leaves.full-days.edit', compact('leave'));
    }

    public function update(Request $request, $id)
    {
        DB::table('attendances_leave')
            ->where('id', $id)
            ->update($request->validate([
                'approve' => ['required', 'numeric', 'min:0', 'max:1']
            ]));

        return redirect()
            ->route('attendances.leaves.full-days.index')
            ->with('success', 'Berhasil mengapprove perizinan');
    }

    public function destroy($id)
    {
        DB::table('attendances_leave')
            ->where('id', $id)
            ->update(['approve' => null]);

        return redirect()
            ->route('attendances.leaves.full-days.index')
            ->with('success', 'Berhasil membatalkan approval perizinan');
    }
}
