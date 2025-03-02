<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GoodController;
use Illuminate\Support\Facades\Route;

Route::prefix('users')->group(function () {
    Route::post('/login', [UserController::class, 'login']);

    //Estos pueden ser solo para admins o servicios generales
    Route::post('/register', [UserController::class, 'register']);
});

Route::prefix('buildings')->group(function () {
    Route::get('/', [BuildingController::class, 'index']);
    Route::get('/{id}', [BuildingController::class, 'show']);
});

Route::prefix('reports')->group(function () {
    Route::get('/', [ReportController::class, 'index']);
    Route::get('/priority/{priority}', [ReportController::class, 'getByPriority']);
    Route::get('/status/{status}', [ReportController::class, 'getByStatus']);
    Route::post('/create', [ReportController::class, 'create'])->middleware('file');
    Route::get('/building/{buildingID}', [ReportController::class, 'getByBuildingId']);
    Route::get('/ordered/{order}', [ReportController::class, 'getOrderedByDate']); // Aqui se colocan los datos ya sea "desc" o "asc"
    Route::get('/folio/{folio}', [ReportController::class, 'getByFolio']);
    Route::put('/update/{reportID}', [ReportController::class, 'update']);

    //Estos pueden ser solo para admins o servicios generales
    Route::put('/update-status/{reportID}', [ReportController::class, 'updateStatus']);
});

Route::prefix('rooms')->group(function () {
    Route::get('/building/{buildingID}', [RoomController::class, 'getByBuildingId']);
});

Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index']);
});

Route::prefix('goods')->group(function () {
    Route::get('/category/{categoryID}', [GoodController::class, 'getByCategoryId']);
});
