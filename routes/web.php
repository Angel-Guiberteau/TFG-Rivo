<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login_register.login_register');
});

Route::get('/home', function () {
    return view('home.home');
})->name('home');

Route::group(['prefix' => 'mockups'], function () {
    Route::get('/home', function () {
        return view('admin.mockups.adminIni');
    })->name('adminIni');
    
    Route::get('/users', function () {
        return view('admin.mockups.adminUsers');
    })->name('adminUsers');

    Route::get('/sentences', function () {
        return view('admin.mockups.adminSentences');
    })->name('adminSentences');

    Route::get('/categories', function () {
        return view('admin.mockups.adminCategories');
    })->name('adminCategories');
});