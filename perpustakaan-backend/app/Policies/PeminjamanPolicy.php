<?php


namespace App\Policies;

use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PeminjamanPolicy
{
    public function modify(User $user, Peminjaman $peminjaman): Response
    {
        return $user->id === $peminjaman->user_id
            ? Response::allow()
            : Response::deny('Anda Tidak Memiliki Izin Untuk Mengubah Peminjaman');
    }
}