<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ProductController;
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

Route::prefix('/v1')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::delete('/logout', [AuthController::class, 'logout'])->middleware(['auth:api']);

    Route::prefix('/product')->group(function () {
        Route::get('/', [ProductController::class, 'index']);
        Route::get('/{product_id}', [ProductController::class, 'show']);
        Route::post('/', [ProductController::class, 'store']);
        Route::put('/{product_id}', [ProductController::class, 'update']);
        Route::delete('/{product_id}', [ProductController::class, 'destroy']);
    });
});
