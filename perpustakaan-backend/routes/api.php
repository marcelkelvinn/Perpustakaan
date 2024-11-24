<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Services\Buku\BukuService;
use App\Services\Denda\DendaService;
use App\Services\Peminjaman\PeminjamanService;
use App\Services\Sirkulasi\SirkulasiService;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('buku')->group(function () {
    Route::post('/', [BukuService::class, 'create']);
    Route::get('/', [BukuService::class, 'getAll']);
    Route::get('/buku/total', [BukuService::class, 'getTotalBuku']);
    Route::get('{id}', [BukuService::class, 'getById']);
    Route::put('{id}', [BukuService::class, 'update']);
    Route::delete('{id}', [BukuService::class, 'delete']);
});

Route::prefix('denda')->group(function () {
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

});

Route::prefix('sirkulasi')->group(function () {
    Route::post('/', [SirkulasiService::class, 'create']);
    Route::get('/', [SirkulasiService::class, 'getAll']);
    Route::get('{id}', [SirkulasiService::class, 'getById']);
    Route::put('{id}', [SirkulasiService::class, 'update']);
    Route::delete('{id}', [SirkulasiService::class, 'delete']);
});