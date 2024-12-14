<?php

namespace App\Services\Buku;

use App\Models\Buku;
use Illuminate\Http\Request;

class BukuService
{
    public function create(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:64',
            'id_pengarang' => 'required|exists:pengarangs,id',
            'id_penerbit' => 'required|exists:penerbits,id',
            'id_kategori' => 'required|exists:kategoris,id',
            'tahun_terbit' => 'required|integer',
        ]);

        return Buku::create($request->all());
    }

    public function getAll()
{
    return Buku::with(['pengarang', 'penerbit', 'kategori'])->get();
}

    public function getTotalBuku()
{
    $totalBuku = Buku::count(); // Menghitung jumlah buku
    return response()->json(['total' => $totalBuku]);
}

    public function getById($id)
    {
        return Buku::findOrFail($id);
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'judul' => 'sometimes|string|max:64',
            'id_pengarang' => 'sometimes|exists:pengarangs,id',
            'id_penerbit' => 'sometimes|exists:penerbits,id',
            'id_kategori' => 'sometimes|exists:kategoris,id',
            'tahun_terbit' => 'sometimes|integer',
        ]);

        $buku = Buku::findOrFail($id);
        $buku->update($request->all());

        return $buku;
    }

    public function delete($id)
    {
        $buku = Buku::findOrFail($id);
        $buku->delete();

        return response()->json(['message' => 'Buku berhasil dihapus']);
    }
}
