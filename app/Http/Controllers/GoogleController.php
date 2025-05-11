<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try{
            $googleUser = Socialite::driver('google')->user();
            $user = User::where('email', $googleUser->getEmail())->first();
            if(!$user)
            {
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'password' => bcrypt(Str::random(30)),
                    'rol_id' => 2,
                ]);
            }
            Auth::login($user);
            $user->load('role');

            return match ($user->role->name) {
                'admin' => redirect()->route('homeAdmin'),
                'user' => redirect()->route('home'),
                default => redirect('/'),
            };

        } catch (\Exception $e) {
            return redirect('/');
        }
    }
}
