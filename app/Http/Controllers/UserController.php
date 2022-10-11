<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::query();

        $users->when(!empty($request->search), function ($query) use ($request) {
            $query->where('name', 'LIKE', "%$request->search%")
                ->orWhere('username', 'LIKE', "%$request->search%")
                ->orWhere('role', 'LIKE', "%$request->search%");
        });

        $users = $users->latest()->paginate(50);

        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'role' => ['required', 'string', Rule::in(['KURIKULUM', 'KARYAWAN'])],
        ]);

        $password = 'snapan';
        $credentials['password'] = bcrypt($password);

        User::create($credentials);

        return redirect()->route('users.index')
            ->with(
                'success',
                "Berhasil menambah user! <br />
                Username: {$credentials['name']} <br />
                Password: $password"
            );
    }
}
