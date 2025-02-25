<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->group(function () {
    Route::prefix('users')->group(function () {
        Route::post('/', [UserController::class, 'store'])
            ->name('users.store');
        
        Route::get('/{id}', [UserController::class, 'show'])
            ->name('users.show');
        
        Route::put('/{id}', [UserController::class, 'update'])
            ->name('users.update');
        
        Route::delete('/{id}', [UserController::class, 'destroy'])
            ->name('users.destroy');
        
        Route::get('/', [UserController::class, 'index'])
            ->name('users.index');
    });
});
