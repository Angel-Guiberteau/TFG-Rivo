<?php

use App\Http\Controllers\GoogleController;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use App\Models\User;

/*
|--------------------------------------------------------------------------
| General Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('auth.login_register');
})->name('/');

Route::get('/home', function () {
    return view('home.home');
})->name('home');


/*
|--------------------------------------------------------------------------
| Google Login/Register Routes
|--------------------------------------------------------------------------
*/
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('login.google');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('google.callback');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'admin'], function () {

    Route::get('/', function () {
        return view('admin.home.home');
    })->name('home');
    
});