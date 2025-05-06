<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login_register');
})->name('/');

Route::get('/home', function () {
    return view('home.home');
})->name('home');

