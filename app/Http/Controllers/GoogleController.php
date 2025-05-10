<?php

namespace App\Http\Controllers;

use App\Models\User;
use Hamcrest\Core\IsNull;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
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
        $googleUser = Socialite::driver('google')->user();
        // dd($googleUser);
        $findUser = User::findGoogleUser($googleUser->getId());

        if(!is_null($findUser)){
            Auth::login($findUser);
        }else{
            User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'password' => bcrypt(Str::random(8)),
                'google_id' => $googleUser->getId(),
            ]);
        }

        return redirect()->route('home');
    }
}
