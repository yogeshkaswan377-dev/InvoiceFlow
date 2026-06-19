<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('company')->paginate(20);
        return view('super-admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        return view('super-admin.users.show', compact('user'));
    }
}
