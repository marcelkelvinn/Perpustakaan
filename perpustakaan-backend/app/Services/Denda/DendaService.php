<?php

namespace App\Services\Denda;

use App\Models\Denda;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;

class DendaService implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('auth:sanctum', except: ['index', 'show'])
        ];
    }

    public function create(Request $request)
    {
        $fields = $request->validate([
            'hari' => 'required|integer',
            'harga_denda' => 'required|integer',
            'status_pembayaran' => 'required|in:sudah dibayar,belum dibayar',
        ]);

        $denda = $request->user()->denda()->create($fields);

        return $denda;
    }

    public function update(Request $request, Denda $denda)
    {
        Gate::authorize('modify', $denda);

        $fields = $request->validate([
            'hari' => 'sometimes|integer',
            'harga_denda' => 'sometimes|integer',
            'status_pembayaran' => 'sometimes|in:sudah dibayar,belum dibayar',
        ]);

        $denda->update($fields);

        return $denda;
    }

    public function delete(Denda $denda)
    {
        Gate::authorize('modify', $denda);

        $denda->delete();

        return ['message' => 'Denda berhasil dihapus'];
    }
}
