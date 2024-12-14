<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role',
        'NIM',
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relasi dengan tabel denda.
     */
    public function Denda()
    {
        return $this->hasMany(Denda::class, 'id_user', 'id');
    }
    
     /**
     * Relasi dengan tabel peminjaman.
     */
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'id_user', 'id');
    }

    /**
     * Relasi dengan tabel ulasan.
     */
    public function ulasan()
    {
        return $this->hasMany(Ulasan::class, 'id_user', 'id');
    }

    /**
     * Relasi dengan tabel sirkulasi.
     */
    public function sirkulasi()
    {
        return $this->hasMany(Sirkulasi::class, 'id_user', 'id');
    }

}
