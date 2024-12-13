<?php

namespace App\Services\Sirkulasi;

use App\Models\Sirkulasi;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;

class SirkulasiService implements HasMiddleware
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
            'id_buku' => 'required|exists:bukus,id',
            'id_user' => 'required|exists:users,id',
            'status' => 'required|string|in:dipinjam,kembali',
        ]);

        $sirkulasi = $request->user()->peminjaman()->create($fields);

        return $sirkulasi;
    }

    public function update(Request $request, Sirkulasi $sirkulasi)
    {
        $fields = $request->validate([
            'id_buku' => 'sometimes|exists:bukus,id',
            'id_user' => 'sometimes|exists:users,id',
            'status' => 'sometimes|string|in:dipinjam,kembali',
        ]);

        $sirkulasi->update($fields);

        return $sirkulasi;
    }

    public function delete(Sirkulasi $sirkulasi)
    {
        Gate::authorize('modify', $sirkulasi);

        $sirkulasi->delete();

        return ['message' => 'Sirkulasi berhasil dihapus'];
    }
}
