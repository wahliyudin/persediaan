<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\IncomingProductController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductOutController;
use App\Http\Controllers\Admin\StockInOutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\TypeController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\WarehouseController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('master-data')->group(function () {
        Route::prefix('satuan')->name('satuan.')->group(function () {
            Route::get('/', [UnitController::class, 'index'])->name('index');
            Route::post('store', [UnitController::class, 'store'])->name('store');
            Route::delete('{unit}/destroy', [UnitController::class, 'destroy'])->name('destroy');
        });
        Route::prefix('jenis')->name('jenis.')->group(function () {
            Route::get('/', [TypeController::class, 'index'])->name('index');
            Route::delete('{type}/destroy', [TypeController::class, 'destroy'])->name('destroy');
        });
        Route::prefix('products')->name('products.')->group(function () {
            Route::get('/', [ProductController::class, 'index'])->name('index');
            Route::get('create', [ProductController::class, 'create'])->name('create');
            Route::post('store', [ProductController::class, 'store'])->name('store');
            Route::get('{id}/edit', [ProductController::class, 'edit'])->name('edit');
            Route::put('{id}/update', [ProductController::class, 'update'])->name('update');
        });
        Route::resource('gudang', WarehouseController::class);
    });

    Route::prefix('incoming-product')->name('incoming-product.')->group(function () {
        Route::get('/', [IncomingProductController::class, 'index'])->name('index');
        Route::get('create', [IncomingProductController::class, 'create'])->name('create');
        Route::post('store', [IncomingProductController::class, 'store'])->name('store');
        Route::get('{id}/edit', [IncomingProductController::class, 'edit'])->name('edit');
        Route::put('{id}/update', [IncomingProductController::class, 'update'])->name('update');
    });

    Route::prefix('product-out')->name('product-out.')->group(function () {
        Route::get('/', [ProductOutController::class, 'index'])->name('index');
        Route::get('create', [ProductOutController::class, 'create'])->name('create');
        Route::post('store', [ProductOutController::class, 'store'])->name('store');
        Route::get('{id}/edit', [ProductOutController::class, 'edit'])->name('edit');
        Route::put('{id}/update', [ProductOutController::class, 'update'])->name('update');
    });

    Route::prefix('inventory')->name('inventory.')->group(function () {
        Route::get('/', [InventoryController::class, 'index'])->name('index');
    });
});

Route::get('/dashboard', [HomeController::class, 'index'])->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';
