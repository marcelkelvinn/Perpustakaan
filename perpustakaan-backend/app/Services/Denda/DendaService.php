<?php

namespace App\Services\Denda;

use App\Models\Denda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class DendaService
{
    // public static function middleware()
    // {
    //     return [
    //         new Middleware('auth:sanctum', except: ['index', 'show'])
    //     ];
    // }

    public function create(Request $request)
{
    // $user = $request->user();
    // if (!$user) {
    //     return response()->json(['error' => 'User  not authenticated'], 401);
    // }

    $fields = $request->validate([
        'id_user' => 'required|exists:users,id',
        'hari' => 'required|integer',
        'harga_denda' => 'required|integer',
        'status_pembayaran' => 'required|in:sudah dibayar,belum dibayar',
    ]);

    // $denda = $user->denda()->create($fields);

    return Denda::create($fields);
}

    public function getById($id)
    {
        return Denda::findOrFail($id);
    }


    public function update(Request $request, Denda $denda)
    {
        // Gate::authorize('modify', $denda);

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
        // Gate::authorize('modify', $denda);

        $denda->delete();

        return ['message' => 'Denda berhasil dihapus'];
    }
}