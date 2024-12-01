<?php

use App\Http\Controllers\SensordataController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('hero');
})->name('hero');

Route::get('/print', function () {
    return view('print');
})->name('print');

//Route::get('/monitoring', function () {
  //  return view('monitoring');
//})->name('monitoring');

Route::get('/monitoring', [SensordataController::class, 'monitoring'])->name('monitoring');
Route::get('/report', [SensordataController::class, 'report'])->name('report');
Route::get('/dashboard', [SensordataController::class, 'dashboard'])->name('dashboard');
Route::post('/checkpin', [SensordataController::class, 'checkpin'])->name('checkpin');