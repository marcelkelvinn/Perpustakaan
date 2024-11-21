<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penerbit extends Model
{
    use HasFactory;

    /**
     * Table name for this model.
     */
    protected $table = 'penerbits';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama',
        'contact',
        'alamat',
    ];

    /**
     * Relasi dengan buku.
     */
    public function buku()
    {
        return $this->hasMany(Buku::class, 'id_penerbit', 'id_penerbit');
    }
}
