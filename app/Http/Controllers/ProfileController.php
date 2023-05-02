<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function show()
    {
        return view('auth.profile');
    }

    public function update(ProfileUpdateRequest $request)
    {
        if ($request->password) {
            auth()->user()->update(['password' => django_password_hash($request->password)]);
        }

        auth()->user()->update([
            'name' => $request->name,
            'username' => $request->username,
        ]);

        return redirect()->back()->with('success', 'Profile updated.');
    }
}
