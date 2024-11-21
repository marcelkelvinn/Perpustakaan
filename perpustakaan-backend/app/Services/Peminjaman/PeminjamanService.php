<?php

namespace App\Services\Peminjaman;

use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PeminjamanService
{
    public function create(Request $request)
    {
        $request->validate([
            'id_user' => 'required|exists:users,id',
            'id_buku' => 'required|exists:bukus,id',
            'tgl_pinjam' => 'required|date',
        ]);

        return Peminjaman::create($request->all());
    }

    public function getAll()
    {
        return Peminjaman::all();
    }

    public function getTotalPeminjaman()
    {
        $totalPeminjaman = Peminjaman::count();
        return response()->json(['total' => $totalPeminjaman]);
    }

    public function getById($id)
    {
        return Peminjaman::findOrFail($id);
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'id_user' => 'sometimes|exists:users,id',
            'id_buku' => 'sometimes|exists:bukus,id',
            'tgl_pinjam' => 'sometimes|date',
        ]);

        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->update($request->all());

        return $peminjaman;
    }

    public function delete($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->delete();

        return response()->json(['message' => 'Peminjaman berhasil dihapus']);
    }
}
