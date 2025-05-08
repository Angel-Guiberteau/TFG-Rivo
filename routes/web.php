<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login_register.login_register');
});

Route::get('/home', function () {
    return view('home.home');
})->name('home');

//temporal
Route::get('/admin', function () {
    return view('admin.mockups.homeAdmin');
})->name('admin');