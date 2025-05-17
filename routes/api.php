<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ParaleloController;
use App\Http\Controllers\EstudianteController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Rutas para el recurso 'estudiantes'
Route::get('/estudiantes', [EstudianteController::class, 'index']);
Route::post('/estudiantes', [EstudianteController::class, 'store']);
Route::get('/estudiantes/{id}', [EstudianteController::class, 'show']);
Route::put('/estudiantes/{id}', [EstudianteController::class, 'update']);
Route::delete('/estudiantes/{id}', [EstudianteController::class, 'destroy']);

// Rutas para el recurso 'paralelos'
Route::get('/paralelos', [ParaleloController::class, 'index']);
Route::post('/paralelos', [ParaleloController::class, 'store']);
Route::get('/paralelos/{id}', [ParaleloController::class, 'show']);
Route::put('/paralelos/{id}', [ParaleloController::class, 'update']);
Route::delete('/paralelos/{id}', [ParaleloController::class, 'destroy']);
