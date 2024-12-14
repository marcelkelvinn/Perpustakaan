<?php

namespace App\Http\Controllers;

use App\Services\Buku\BukuService;

class BukuController extends Controller
{
    protected $bukuService;

    public function __construct(BukuService $bukuService)
    {
        $this->bukuService = $bukuService;
    }

    public function index()
    {
        // Mengembalikan data buku beserta relasi
        return response()->json(['success' => true, 'data' => $this->bukuService->getAll()]);
    }
}
