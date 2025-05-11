<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login_register.login_register');
});

Route::get('/home', function () {
    return view('home.home');
})->name('home');

Route::group(['prefix' => 'admin'], function () {
    Route::get('/home', function () {
        return view('admin.home.home');
    })->name('home');
    
    Route::get('/users', function () {
        return view('admin.users.users');
    })->name('users');

    Route::get('/sentences', function () {
        return view('admin.sentences.sentences');
    })->name('sentences');

    Route::get('/categories', function () {
        return view('admin.categories.categories');
    })->name('categories');
});