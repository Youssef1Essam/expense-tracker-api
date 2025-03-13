<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BudgetController;

Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware('auth:api')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::get('profile', [AuthController::class, 'userProfile']);
        Route::get('user', function (Request $request) {
            return $request->user();
        });
    });
});

Route::middleware('auth:api')->prefix('v1')->group(function () {
    Route::middleware('throttle:100,1')->apiResource('expenses', ExpenseController::class);
    Route::middleware('throttle:60,1')->apiResource('categories', CategoryController::class);
    Route::middleware('throttle:30,1')->apiResource('budgets', BudgetController::class);
});
