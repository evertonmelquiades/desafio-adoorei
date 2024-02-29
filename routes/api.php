<?php

use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\SaleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::apiResource('products', ProductController::class);

Route::apiResource('sales', SaleController::class);
Route::delete('/sales/{id}/cancel', [SaleController::class, 'cancel']);
Route::put('/sales/{id}/made', [SaleController::class, 'madeSale']);
Route::post('/sales/{sale}/products/{product}', [SaleController::class, 'addProduct']);
