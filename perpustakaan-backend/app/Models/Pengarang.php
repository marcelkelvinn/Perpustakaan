<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengarang extends Model
{
    use HasFactory;

    /**
     * Table name for this model.
     */
    protected $table = 'pengarangs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama',
        'biodata',
    ];

    /**
     * Relasi dengan buku.
     */
    public function buku()
    {
        return $this->hasMany(Buku::class, 'id_pengarang', 'id_pengarang');
    }
}
