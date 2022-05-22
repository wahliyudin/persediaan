<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\TypeController;
use App\Http\Controllers\Admin\UnitController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('master-data')->group(function () {
        Route::resource('satuan', UnitController::class);
        Route::resource('jenis', TypeController::class);
        Route::resource('barang', ProductController::class);
    });
});

Route::get('/dashboard', [HomeController::class, 'index'])->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
