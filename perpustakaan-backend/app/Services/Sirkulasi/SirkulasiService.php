<?php

namespace App\Services\Sirkulasi;

use App\Models\Sirkulasi;
use Illuminate\Http\Request;

class SirkulasiService
{
    public function create(Request $request)
    {
        $request->validate([
            'id_buku' => 'required|exists:bukus,id',
            'id_user' => 'required|exists:users,id',
            'status' => 'required|string|in:dipinjam,kembali',
        ]);

        return Sirkulasi::create($request->all());
    }

    public function getAll()
    {
        return Sirkulasi::all();
    }

    public function getById($id)
    {
        return Sirkulasi::findOrFail($id);
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'id_buku' => 'sometimes|exists:bukus,id',
            'id_user' => 'sometimes|exists:users,id',
            'status' => 'sometimes|string|in:dipinjam,kembali',
        ]);

        $sirkulasi = Sirkulasi::findOrFail($id);
        $sirkulasi->update($request->all());

        return $sirkulasi;
    }

    public function delete($id)
    {
        $sirkulasi = Sirkulasi::findOrFail($id);
        $sirkulasi->delete();

        return response()->json(['message' => 'Sirkulasi berhasil dihapus']);
    }
}
