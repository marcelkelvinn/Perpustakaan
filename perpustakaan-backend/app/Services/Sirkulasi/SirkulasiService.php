<?php

namespace App\Services\Sirkulasi;

use App\Models\Sirkulasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class SirkulasiService 
{

    /**
     * Create a new sirkulasi record.
     */
    public function create(Request $request)
    {
        $fields = $request->validate([
            'id_buku' => 'required|exists:bukus,id',
            'id_user' => 'required|exists:users,id',
            'tgl_pinjam' => 'required|date',
            'status' => 'required|string|in:dipinjam,kembali',
        ]);

        $sirkulasi = Sirkulasi::create($fields);

        return $sirkulasi->load(['buku:id,judul', 'user:id,name']);
    }

    /**
     * Update an existing sirkulasi record.
     */
    public function update(Request $request, Sirkulasi $sirkulasi)
    {
        $fields = $request->validate([
            'id_buku' => 'sometimes|exists:bukus,id',
            'id_user' => 'sometimes|exists:users,id',
            'tgl_kembali' => 'sometimes|date',
            'tgl_pengembalian' => 'sometimes|date',
            'status' => 'sometimes|string|in:dipinjam,kembali',
        ]);

        $sirkulasi->update($fields);

        return $sirkulasi->load(['buku:id,judul', 'user:id,name']);
    }

    /**
     * Delete a sirkulasi record.
     */
    public function delete(Sirkulasi $sirkulasi)
    {
        Gate::authorize('modify', $sirkulasi);

        $sirkulasi->delete();

        return ['message' => 'Sirkulasi berhasil dihapus'];
    }

    public function getAll()
    {
        // Load the relations 'buku' and 'user' to retrieve book title and user name
        return Sirkulasi::with(['buku:id,judul', 'user:id,name'])->get();
    }


    /**
     * Retrieve all sirkulasi records with optional filters.
     */
    public function index(Request $request)
    {
        $query = Sirkulasi::with(['buku:id,judul', 'user:id,name']); // Load related data with specific fields

        if ($request->has('status')) {
            $query->filterByStatus($request->status);
        }

        if ($request->has(['start_date', 'end_date'])) {
            $query->filterByTanggalPinjam($request->start_date, $request->end_date);
        }

        return $query->get();
    }



    /**
     * Retrieve a single sirkulasi record by ID.
     */
    public function show(Sirkulasi $sirkulasi)
    {
        return $sirkulasi->load(['buku', 'user']);
    }
}
