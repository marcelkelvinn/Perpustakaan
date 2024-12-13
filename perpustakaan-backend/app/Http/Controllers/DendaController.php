<?php

namespace App\Http\Controllers;

use App\Models\Denda;
use App\Services\Denda\DendaService;
use Illuminate\Http\Request;

class DendaController extends Controller
{
    protected $dendaService;

    public function __construct(DendaService $dendaService)
    {
        $this->dendaService = $dendaService;
    }

    // Menampilkan semua denda
    public function index()
    {
        $dendas = Denda::all();
        return response()->json($dendas);
    }

    // Menyimpan denda baru
    public function store(Request $request)
    {
        $denda = $this->dendaService->create($request);
        return response()->json($denda, 201);
    }

    // Memperbarui denda yang ada
    public function update(Request $request, Denda $denda)
    {
        $denda = $this->dendaService->update($request, $denda);
        return response()->json($denda);
    }

    // Menghapus denda
    public function destroy(Denda $denda)
    {
        $response = $this->dendaService->delete($denda);
        return response()->json($response);
    }
}