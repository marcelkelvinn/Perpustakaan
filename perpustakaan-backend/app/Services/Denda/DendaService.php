<?php

namespace App\Services\Denda;

use App\Models\Denda;
use Illuminate\Http\Request;

class DendaService
{
    public function create(Request $request)
    {
        $request->validate([
            'hari' => 'required|integer',
            'harga_denda' => 'required|integer',
            'status_pembayaran' => 'required|in:sudah dibayar,belum dibayar',
        ]);

        return Denda::create($request->all());
    }

    public function getAll()
    {
        return Denda::all();
    }

    public function getTotalDenda()
    {
        $totalDenda = Denda::count();
        return response()->json(['total' => $totalDenda]);
    }

    public function getById($id)
    {
        return Denda::findOrFail($id);
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'hari' => 'sometimes|integer',
            'harga_denda' => 'sometimes|integer',
            'status_pembayaran' => 'sometimes|in:sudah dibayar,belum dibayar',
        ]);

        $denda = Denda::findOrFail($id);
        $denda->update($request->all());

        return $denda;
    }

    public function delete($id)
    {
        $denda = Denda::findOrFail($id);
        $denda->delete();

        return response()->json(['message' => 'Denda berhasil dihapus']);
    }
}
