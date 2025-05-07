<?php

use App\Http\Controllers\GoogleController;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use App\Models\User;

// [ ------------- GENERAL ROUTES -------------]

Route::get('/', function () {
    return view('auth.login_register');
})->name('/');

Route::get('/home', function () {
    return view('home.home');
})->name('home');

// [ ------------- GOOGLE LOGIN -------------]

Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('login.google');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('google.callback');