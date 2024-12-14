<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul', 'id_pengarang', 'id_penerbit', 'id_kategori', 'tahun_terbit',
    ];

    // Relasi dengan pengarang
    public function pengarang()
    {
        return $this->belongsTo(Pengarang::class, 'id_pengarang');
    }

    // Relasi dengan penerbit
    public function penerbit()
    {
        return $this->belongsTo(Penerbit::class, 'id_penerbit');
    }

    // Relasi dengan kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }
}