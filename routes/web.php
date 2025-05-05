<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/mockups', function () {
    return view('mockups.mockup');
});

Route::get('/home', function () {
    return view('mockups.home');
});