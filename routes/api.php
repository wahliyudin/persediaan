<?php

use App\Http\Controllers\API\IncomingProductController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\TypeController;
use App\Http\Controllers\API\UnitController;
use App\Http\Controllers\API\WarehouseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::name('api.')->group(function () {
    Route::prefix('units')->name('units.')->group(function () {
        Route::post('/', [UnitController::class, 'index'])->name('index');
        Route::post('store', [UnitController::class, 'store'])->name('store');
        Route::get('{id}/edit', [UnitController::class, 'edit'])->name('edit');
        Route::put('{id}/update', [UnitController::class, 'update'])->name('update');
        Route::delete('{id}/destroy', [UnitController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('types')->name('types.')->group(function () {
        Route::post('/', [TypeController::class, 'index'])->name('index');
        Route::post('store', [TypeController::class, 'store'])->name('store');
        Route::get('{id}/edit', [TypeController::class, 'edit'])->name('edit');
        Route::put('{id}/update', [TypeController::class, 'update'])->name('update');
        Route::delete('{id}/destroy', [TypeController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('warehouses')->name('warehouses.')->group(function () {
        Route::post('/', [WarehouseController::class, 'index'])->name('index');
        Route::post('store', [WarehouseController::class, 'store'])->name('store');
        Route::get('{id}/edit', [WarehouseController::class, 'edit'])->name('edit');
        Route::put('{id}/update', [WarehouseController::class, 'update'])->name('update');
        Route::delete('{id}/destroy', [WarehouseController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('products')->name('products.')->group(function () {
        Route::get('{id}', [ProductController::class, 'getProduct'])->name('get-product');
        Route::post('/', [ProductController::class, 'index'])->name('index');
        Route::delete('{id}/destroy', [ProductController::class, 'destroy'])->name('destroy');
    });

    Route::delete('incoming-products/{id}/destroy', [IncomingProductController::class, 'destroy'])->name('destroy');
});
