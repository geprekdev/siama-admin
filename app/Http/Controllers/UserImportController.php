<?php

namespace App\Http\Controllers;

use App\Imports\UserImport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class UserImportController extends Controller
{
    public function create()
    {
        return view('users.import');
    }

    public function store(Request $request)
    {
        $request->validate([
            'role' => ['required', Rule::in(array_keys(User::ROLE_SELECT))],
            'file' => ['required', 'file', 'mimes:csv,xlsx', 'max:10240'],
        ]);

        Excel::import(new UserImport($request->input('role')), $request->file('file'));

        return redirect()->route('users.index')
            ->with('success', 'Berhasil mengimport user');
    }
}
