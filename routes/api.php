<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ItemController;
use App\Http\Controllers\WarehouseLocationController;
use App\Http\Controllers\TransactionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Item routes
Route::get('/items', [ItemController::class, 'index']);
Route::get('/items/{id}', [ItemController::class, 'show']);
Route::post('/items', [ItemController::class, 'store']);
Route::put('/items/{id}', [ItemController::class, 'update']);
Route::delete('/items/{id}', [ItemController::class, 'destroy']);


// WarehouseLocation routes
Route::get('/warehouse-locations', [WarehouseLocationController::class, 'index']);
Route::get('/warehouse-locations/{id}', [WarehouseLocationController::class, 'show']);
Route::get('/warehouselocation-by-code/{id}', [WarehouseLocationController::class, 'showByCode']);
Route::post('/warehouse-locations', [WarehouseLocationController::class, 'store']);
Route::put('/warehouse-locations/{id}', [WarehouseLocationController::class, 'update']);
Route::delete('/warehouse-locations/{id}', [WarehouseLocationController::class, 'destroy']);


// Transaction routes
Route::get('/transactions', [TransactionController::class, 'index']);
Route::get('/transactions/{id}', [TransactionController::class, 'show']);
Route::post('/transactions', [TransactionController::class, 'store']);
Route::put('/transactions/{id}', [TransactionController::class, 'update']);
Route::delete('/transactions/{id}', [TransactionController::class, 'destroy']);

Route::post('/receive-item', [TransactionController::class, 'receiveItem']);
