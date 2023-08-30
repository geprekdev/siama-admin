<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::with('groups');

        $users->when(!empty($request->search), function (Builder $query) use ($request) {
            $query->where('first_name', 'LIKE', "%$request->search%")
                ->orWhere('username', 'LIKE', "%$request->search%");
        });

        $users = $users->latest('id')->paginate(50);

        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'groups' => ['required', 'array'],
            'groups.*' => ['required', 'string', Rule::in(array_keys(User::ROLE_SELECT))]
        ]);

        $password = 'snapan';
        $hashedPassword = django_password_hash($password);

        $user = User::create([
            'first_name' => $request->first_name,
            'username' => $request->username,
            'password' => $hashedPassword,
            'is_superuser' => false,
            'is_staff' => false,
            'is_active' => true,
            'last_name' => '',
            'email' => '',
            'date_joined' => now(),
        ]);

        $groupIds = Group::query()
            ->whereIn('name', $request->groups)
            ->pluck('id')
            ->toArray();

        $user->groups()->attach($groupIds);

        return redirect()->route('users.index')
            ->with(
                'success',
                "Berhasil menambah user! <br />
                Username: {$request->username} <br />
                Password: $password"
            );
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', Rule::unique('auth_user')->ignore($user)],
            'groups' => ['required', 'array'],
            'groups.*' => ['required', 'string', Rule::in(array_keys(User::ROLE_SELECT))]
        ]);

        $user->update([
            'first_name' => $request->first_name,
            'username' => $request->username,
        ]);

        $user->groups()->detach();

        $groupIds = Group::query()
            ->whereIn('name', $request->groups)
            ->pluck('id')
            ->toArray();

        $user->groups()->attach($groupIds);

        return redirect()->route('users.index')
            ->with(
                'success',
                'Berhasil mengedit user!'
            );
    }

    public function destroy(User $user)
    {
        DB::transaction(function () use ($user) {
            DB::table('classrooms_classroom_student')->where('user_id', $user->id)->delete();
            $user->groups()->detach();
            $user->delete();
        });

        return redirect()->route('users.index')
            ->with(
                'success',
                'Berhasil menghapus user!'
            );
    }
}
