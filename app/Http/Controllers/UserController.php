<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(50);

        return view('users.index', compact('users'));
    }
}
