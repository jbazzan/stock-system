<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SaleDetailController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/login', [AuthController::class, 'loginUser']);
Route::apiResource('saleDetails', SaleDetailController::class);

Route::middleware(['auth:sanctum'])->group(function(){
    Route::post('/create', [AuthController::class, 'createUser']);
    Route::get('/user', function (Request $request) {return $request->user();});
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('products', ProductController::class);
    Route::apiResource('clients', ClientController::class);
    Route::apiResource('sales', SaleController::class);
    Route::apiResource('discounts', DiscountController::class);
    Route::apiResource('roles', RoleController::class);
    Route::get('/users', [AuthController::class, 'getAllUsers']);
    Route::get('/users/{id}', [AuthController::class, 'getUser']);
    Route::put('/users/{id}', [AuthController::class, 'updateUser']);
    Route::delete('/users/{id}', [AuthController::class, 'destroy']);
    Route::get('/sales/by-client/{client_id}', [SaleController::class, 'getSalesByClient']);
    Route::put('/sales/recalculate/{id}', [SaleController::class, 'Recalculate']);
});