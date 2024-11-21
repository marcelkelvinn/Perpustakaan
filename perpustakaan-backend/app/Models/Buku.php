<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    /**
     * Table name for this model.
     */
    protected $table = 'bukus';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'judul',
        'id_pengarang',
        'id_penerbit',
        'id_kategori',
        'tahun_terbit',
    ];

    /**
     * Relasi dengan pengarang.
     */
    public function pengarang()
    {
        return $this->belongsTo(Pengarang::class, 'id_pengarang', 'id_pengarang');
    }

    /**
     * Relasi dengan penerbit.
     */
    public function penerbit()
    {
        return $this->belongsTo(Penerbit::class, 'id_penerbit', 'id_penerbit');
    }

    /**
     * Relasi dengan kategori.
     */
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    /**
     * Relasi dengan ulasan.
     */
    public function ulasan()
    {
        return $this->hasMany(Ulasan::class, 'id_buku', 'id_buku');
    }
}
