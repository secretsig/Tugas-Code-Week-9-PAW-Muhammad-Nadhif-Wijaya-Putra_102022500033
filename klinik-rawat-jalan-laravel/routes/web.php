<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RuangController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('login.process')->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware('auth')->group(function () {

    Route::middleware('role:admin,petugas')->group(function () {
        Route::get('/', [RuangController::class, 'index'])->name('ruang.index');
        Route::get('/ruang/{id}', [RuangController::class, 'show'])->name('ruang.show');
        Route::post('/ruang', [RuangController::class, 'storeRuang'])->name('ruang.store');
        Route::get('/ruang/{id}/edit', [RuangController::class, 'editRuang'])->name('ruang.edit');
        Route::put('/ruang/{id}', [RuangController::class, 'updateRuang'])->name('ruang.update');
        Route::post('/ruang/{id}/alat', [RuangController::class, 'storeAlat'])->name('alat.store');
    });

    Route::middleware('role:admin')->group(function () {
        Route::delete('/ruang/{id}', [RuangController::class, 'destroyRuang'])->name('ruang.destroy');
        Route::delete('/alat/{id}', [RuangController::class, 'destroyAlat'])->name('alat.destroy');
    });
});