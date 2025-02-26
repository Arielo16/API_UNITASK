<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\BuildingController;
use Illuminate\Support\Facades\Route;

Route::prefix('users')->group(function () {
    Route::post('/register', [UserController::class, 'register']);
    Route::post('/login', [UserController::class, 'login']);
});

Route::prefix('buildings')->group(function () {
    Route::get('/', [BuildingController::class, 'index']);
    Route::get('/{id}', [BuildingController::class, 'show']);
});
