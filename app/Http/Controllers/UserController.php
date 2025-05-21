<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getUser(): ?Authenticatable
    {
        return User::getUser();
    }
    public function updateUserInfo($request): ?Authenticatable
    {

        dd($request);
    }
}
