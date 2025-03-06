<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GoodController;
use App\Http\Controllers\DiagnosticController; // Asegúrate de importar el controlador
use App\Http\Controllers\ImageController; // Importar el controlador de imágenes
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
    //Obtener todos los reportes
    Route::get('/', [ReportController::class, 'index']);

    //Filtro: Buscar por prioridad [Immediate, Normal]
    Route::get('/priority/{priority}', [ReportController::class, 'getByPriority']);

    //Filtro: Buscar por estatus [Enviado, Diagnosticado, En Proceso, Terminado]
    Route::get('/status/{status}', [ReportController::class, 'getByStatus']);

    Route::post('/create', [ReportController::class, 'create']);

    //Filtro: Buscar por edificio (Tambien conocido como "Ubicación")
    Route::get('/building/{buildingID}', [ReportController::class, 'getByBuildingId']);

    //Filtros: Buscar por fecha de creación [asc, desc]
    Route::get('/ordered/{order}', [ReportController::class, 'getOrderedByDate']);

    //Filtro: Buscar por folio
    Route::get('/folio/{folio}', [ReportController::class, 'getByFolio']);

    //Actualizar datos de un reporte
    Route::put('/update/{reportID}', [ReportController::class, 'update']);

//Estos pueden ser solo para admins o servicios generales
    //Actualizar estatus de reporte [Enviado, Diagnosticado, En Proceso, Terminado]
    Route::put('/update-status/{reportID}', [ReportController::class, 'updateStatus']);

    Route::get('/check-status/{reportID}', [ReportController::class, 'checkStatus']);
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


Route::prefix('diagnostics')->group(function () {
    Route::post('/create', [DiagnosticController::class, 'create']);
    Route::get('/report/{reportID}', [DiagnosticController::class, 'getByReportID']);
    Route::put('/update-status/{reportID}', [DiagnosticController::class, 'updateStatus']);

    //Filtro: Buscar por estatus [Enviado, Para Reparar, En Proceso, Terminado]
    Route::get('/status/{status}', [DiagnosticController::class, 'getByStatus']); 

    //Filtros: Buscar por fecha de creación [asc, desc]
    Route::get('/ordered/{order}', [DiagnosticController::class, 'getOrderedByDate']);
});

// Ruta para manejar la subida de imágenes
Route::post('/images/upload', [ImageController::class, 'store']);
