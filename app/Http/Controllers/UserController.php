<?php

namespace App\Http\Controllers;

use App\User;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.users.index');
    }

    public function indexData()
    {
        $users = User::all();

        return response()->custom(200, "All users!", $users);
    }
}
