<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('hero');
})->name('hero');

Route::get('/dashboard', function () {
    return view('welcome');
})->name('dashboard');

Route::get('/report', function () {
    return view('report');
})->name('report');

Route::get('/print', function () {
    return view('print');
})->name('print');