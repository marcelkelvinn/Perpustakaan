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

    public function index()
    {
        $dendas = Denda::all();
        return response()->json($dendas);
    }

    public function store(Request $request)
    {
        $denda = $this->dendaService->create($request);
        return response()->json($denda, 201);
    }

    public function show($id)
    {
        $denda = $this->dendaService->getById($id);
        return response()->json($denda);
    }

    public function update(Request $request, Denda $denda)
    {
        $updatedDenda = $this->dendaService->update($request, $denda);
        return response()->json($updatedDenda);
    }
    
    public function destroy(Denda $denda)
    {
        $response = $this->dendaService->delete($denda);
        return response()->json($response);
    }
}