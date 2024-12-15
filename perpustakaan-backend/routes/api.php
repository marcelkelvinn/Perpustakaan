<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\DendaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Services\Buku\BukuService;
use App\Services\Peminjaman\PeminjamanService;
use App\Services\Sirkulasi\SirkulasiService;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/user', [UserController::class, 'getUserProfile'])->middleware('auth:sanctum');
Route::middleware('auth:sanctum')->put('/uprofile/{user}', [UserController::class, 'updateProfile']);

Route::prefix('buku')->group(function () {
    Route::post('/', [BukuService::class, 'create'])->middleware('auth:sanctum');
    Route::get('/', [BukuService::class, 'getAll']);
    Route::get('{id}', [BukuService::class, 'getById']);
    Route::put('{id}', [BukuService::class, 'update'])->middleware('auth:sanctum');
    Route::delete('{id}', [BukuService::class, 'delete'])->middleware('auth:sanctum');
    Route::get('/buku', [BukuController::class, 'index']);
});

Route::apiResource('dendas', DendaController::class);

Route::prefix('peminjaman')->group(function () {
    Route::post('/', [PeminjamanService::class, 'create'])->middleware('auth:sanctum');
    Route::put('{id}', [PeminjamanService::class, 'update'])->middleware('auth:sanctum');
    Route::delete('{id}', [PeminjamanService::class, 'delete'])->middleware('auth:sanctum');
});

Route::prefix('sirkulasi')->group(function () {
    Route::post('/', [SirkulasiService::class, 'create'])->middleware('auth:sanctum');
    Route::get('/', [SirkulasiService::class, 'getAll']);
    Route::get('{id}', [SirkulasiService::class, 'getById']);
    Route::put('{id}', [SirkulasiService::class, 'update'])->middleware('auth:sanctum');
    Route::delete('{id}', [SirkulasiService::class, 'delete'])->middleware('auth:sanctum');
});