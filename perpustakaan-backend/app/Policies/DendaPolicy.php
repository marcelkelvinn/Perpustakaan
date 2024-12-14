<?php


namespace App\Policies;

use App\Models\Denda;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DendaPolicy
{
    public function modify(User $user, Denda $denda): Response
    {
        return $user->id === $denda->user_id
            ? Response::allow()
            : Response::deny('Anda Tidak Memiliki Izin Untuk Mengubah Denda');
    }
}