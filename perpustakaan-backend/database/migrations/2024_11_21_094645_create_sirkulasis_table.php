<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sirkulasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_buku')->constrained('bukus')->cascadeOnDelete();
            $table->foreignId('id_user')->constrained('users')->cascadeOnDelete();
            $table->date('tgl_pinjam');
            $table->date('tgl_kembali')->nullable();
            $table->date('tgl_pengembalian')->nullable();
            $table->enum('status', ['pinjam', 'kembali']);
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sirkulasis');
    }
};
