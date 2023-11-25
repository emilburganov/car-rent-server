<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarClassController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\CarModelController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/* Auth */
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // Client routes
    Route::middleware('role:1')->group(function() {
        Route::get('/cars', [CarController::class, 'index']);
    });

    // Admin routes
    Route::middleware('role:2')->group(function() {
        Route::get('/cars', [CarController::class, 'index']);
        Route::post('/cars', [CarController::class, 'create']);
        Route::patch('/cars/{car}', [CarController::class, 'update']);
        Route::delete('/cars/{car}', [CarController::class, 'destroy']);

        Route::get('/car-models', [CarModelController::class, 'index']);

        Route::get('/car-classes', [CarClassController::class, 'index']);
    });
});
