<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Services\Buku\BukuService;
use App\Services\Denda\DendaService;
use App\Services\Peminjaman\PeminjamanService;
use App\Services\Sirkulasi\SirkulasiService;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::prefix('buku')->group(function () {
    Route::post('/', [BukuService::class, 'create'])->middleware('auth:sanctum');
    Route::get('/', [BukuService::class, 'getAll']);
    Route::get('{id}', [BukuService::class, 'getById']);
    Route::put('{id}', [BukuService::class, 'update'])->middleware('auth:sanctum');
    Route::delete('{id}', [BukuService::class, 'delete'])->middleware('auth:sanctum');
});

Route::prefix('denda')->group(function () {
<<<<<<< HEAD
    Route::post('/', [DendaService::class, 'create']);
    Route::get('/', [DendaService::class, 'getAll']);
    Route::get('/peminjaman/total', [PeminjamanService::class, 'getTotalPeminjaman']);
    Route::get('{id}', [DendaService::class, 'getById']);
    Route::put('{id}', [DendaService::class, 'update']);
    Route::delete('{id}', [DendaService::class, 'delete']);
    Route::get('/peminjam', [PeminjamanService::class, 'getAll']);
});

Route::prefix('peminjaman')->group(function () {
    Route::post('/', [PeminjamanService::class, 'create']);
    Route::get('/', [PeminjamanService::class, 'getAll']);
    Route::get('/denda/total', [DendaService::class, 'getTotalDenda']);
    Route::get('{id}', [PeminjamanService::class, 'getById']);
    Route::put('{id}', [PeminjamanService::class, 'update']);
    Route::delete('{id}', [PeminjamanService::class, 'delete']);
    // Route::get('/users', [UserService::class, 'getAll']);
    Route::get('/bukus', [BukuService::class, 'getAll']);

=======
    Route::post('/', [DendaService::class, 'create'])->middleware('auth:sanctum');
    Route::put('{id}', [DendaService::class, 'update'])->middleware('auth:sanctum');
    Route::delete('{id}', [DendaService::class, 'delete'])->middleware('auth:sanctum');
});

Route::prefix('peminjaman')->group(function () {
    Route::post('/', [PeminjamanService::class, 'create'])->middleware('auth:sanctum');
    Route::put('{id}', [PeminjamanService::class, 'update'])->middleware('auth:sanctum');
    Route::delete('{id}', [PeminjamanService::class, 'delete'])->middleware('auth:sanctum');
>>>>>>> upstream/main
});

Route::prefix('sirkulasi')->group(function () {
    Route::post('/', [SirkulasiService::class, 'create'])->middleware('auth:sanctum');
    Route::put('{id}', [SirkulasiService::class, 'update'])->middleware('auth:sanctum');
    Route::delete('{id}', [SirkulasiService::class, 'delete'])->middleware('auth:sanctum');
});