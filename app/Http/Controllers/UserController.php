<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public static function listUsers()
    {
        $users = User::getAllUsers();
    
        return view('admin.users.users')
            ->with('users', $users);
    }
}
