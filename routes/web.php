<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('dashboard');

Route::get('/report', function () {
    return view('report');
})->name('report');