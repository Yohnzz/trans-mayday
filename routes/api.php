<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SalaryController;
use App\Http\Controllers\Api\EmployeeController;

Route::post('/hitung-gaji', [SalaryController::class, 'hitung']);

Route::get('/history-gaji', [SalaryController::class, 'history']);
Route::get('/history-gaji/{id}', [SalaryController::class, 'historyByEmployee']);
Route::delete('/history-gaji/{id}', [SalaryController::class, 'deleteHistory']);
// Route::get('/employees', [EmployeeController::class, 'index']);
// Route::post('/employees', [EmployeeController::class, 'store']);


Route::prefix('elpetugasanjirrr')->group(function () {
    Route::get('/employees', [EmployeeController::class, 'index']);
    // Route::get('/employees/{id}', [EmployeeController::class, 'index']);
    Route::post('/employees', [EmployeeController::class, 'store']);
    Route::put('/employees/{id}', [EmployeeController::class, 'update']);

});

// Route::get('/history-gaji', [GajiController::class, 'history']);

