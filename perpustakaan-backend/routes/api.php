<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Services\Buku\BukuService;
use App\Services\Denda\DendaService;
use App\Services\Peminjaman\PeminjamanService;
use App\Services\Sirkulasi\SirkulasiService;

Route::get('/', function() {
    return 'welcome';
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::prefix('buku')->group(function () {
    Route::post('/', [BukuService::class, 'create']);
    Route::get('/', [BukuService::class, 'getAll']);
    Route::get('{id}', [BukuService::class, 'getById']);
    Route::put('{id}', [BukuService::class, 'update']);
    Route::delete('{id}', [BukuService::class, 'delete']);
});

Route::prefix('denda')->group(function () {
    Route::post('/', [DendaService::class, 'create']);
    Route::put('{id}', [DendaService::class, 'update']);
    Route::delete('{id}', [DendaService::class, 'delete']);
});

Route::prefix('peminjaman')->group(function () {
    Route::post('/', [PeminjamanService::class, 'create']);
    Route::put('{id}', [PeminjamanService::class, 'update']);
    Route::delete('{id}', [PeminjamanService::class, 'delete']);
});

Route::prefix('sirkulasi')->group(function () {
    Route::post('/', [SirkulasiService::class, 'create']);
    Route::put('{id}', [SirkulasiService::class, 'update']);
    Route::delete('{id}', [SirkulasiService::class, 'delete']);
});