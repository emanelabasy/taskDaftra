<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\StockController;
use App\Http\Controllers\Api\StockTransferController;
use App\Http\Controllers\Api\InventoryController;
use App\Http\Controllers\Api\WarehouseInventoryController;

Route::namespace('Api')->middleware(['throttle:60,1'])->group(function () {

    Route::post('/auth/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/auth/logout', [AuthController::class, 'logout']);
        Route::get('/auth/profile', [AuthController::class, 'profile']);

        //todo:
        Route::post('/stock-transfers', [StockTransferController::class, 'store'])
            ->middleware('abilities:transfers:create');

        Route::post('/stocks/adjust', [StockController::class, 'adjustStock'])
            ->middleware('abilities:stock:update');

    });

    Route::get('/inventory', [InventoryController::class, 'index']);

    Route::get('/warehouses/inventory', [WarehouseInventoryController::class, 'index']);
    Route::get('/warehouses/{warehouse}/inventory', [WarehouseInventoryController::class, 'show']); 
   

    Route::get('/stock-transfers', [StockTransferController::class, 'index']);
    Route::get('/stock-transfers/{stockTransfer}', [StockTransferController::class, 'show']); 


});

