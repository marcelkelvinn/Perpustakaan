<?php


namespace App\Policies;

use App\Models\Sirkulasi;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SirkulasiPolicy
{
    public function modify(User $user, Sirkulasi $sirkulasi): Response
    {
        return $user->id === $sirkulasi->user_id
            ? Response::allow()
            : Response::deny('Anda Tidak Memiliki Izin Untuk Mengubah Sirkulasi');
    }
}