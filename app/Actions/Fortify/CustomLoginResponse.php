<?php

namespace App\Actions\Auth;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

class CustomLoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        dd('hola');
        $user = Auth::user();
        $role = $user->role->name ?? 'user';
        dd($role);

        $redirect = match ($role) {
            'admin' => route('homeAdmin'),
            'user' => route('home'),
            default => '/',
        };

        return redirect()->intended($redirect);
    }
}
