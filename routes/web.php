<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\StockInOutController;
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
        Route::prefix('satuan')->name('satuan.')->group(function () {
            Route::get('/', [UnitController::class, 'index'])->name('index');
            Route::delete('{unit}/destroy', [UnitController::class, 'destroy'])->name('destroy');
        });
        Route::prefix('jenis')->name('jenis.')->group(function () {
            Route::get('/', [TypeController::class, 'index'])->name('index');
            Route::delete('{type}/destroy', [TypeController::class, 'destroy'])->name('destroy');
        });
        Route::resource('barang', ProductController::class);
    });

    Route::prefix('stok-in-out')->name('stok-in-out.')->group(function () {
        Route::get('/', [StockInOutController::class, 'index'])->name('index');
    });

    Route::prefix('inventory')->name('inventory.')->group(function () {
        Route::get('/', [InventoryController::class, 'index'])->name('index');
    });
});

Route::get('/dashboard', [HomeController::class, 'index'])->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';
