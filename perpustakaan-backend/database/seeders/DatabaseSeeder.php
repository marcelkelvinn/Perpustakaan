<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('users')->truncate();
        DB::table('dendas')->truncate();
        DB::table('kategoris')->truncate();
        DB::table('penerbits')->truncate();
        DB::table('pengarangs')->truncate();
        DB::table('bukus')->truncate();
        DB::table('peminjamans')->truncate();
        DB::table('sirkulasis')->truncate();
        DB::table('ulasans')->truncate();

        // Insert data dummy untuk user terlebih dahulu
        DB::table('users')->insert([
            [
                'name' => 'Mahasiswa A',
                'email' => 'mahasiswaA@example.com',
                'password' => Hash::make('password'),
                'role' => 'mahasiswa',
                'NIM' => '12345678901',
            ],
            [
                'name' => 'Admin B',
                'email' => 'adminB@example.com',
                'password' => Hash::make('adminpassword'),
                'role' => 'admin',
                'NIM' => null,
            ]
        ]);

        // Insert data dummy untuk denda
        DB::table('dendas')->insert([
            [
                'hari' => 2,  // Jumlah hari keterlambatan
                'harga_denda' => 5000,  // Jumlah denda
                'status_pembayaran' => 'belum dibayar',  // Status pembayaran
            ],
            [
                'hari' => 3,
                'harga_denda' => 10000,
                'status_pembayaran' => 'belum dibayar',
            ]
        ]);

        // Insert data dummy untuk kategori
        DB::table('kategoris')->insert([
            [
                'kategori' => 'Pemrograman',
                'keterangan' => 'Kursus tentang bahasa pemrograman',  // Menambahkan keterangan
            ],
            [
                'kategori' => 'Web Development',
                'keterangan' => 'Kursus tentang pengembangan website',  // Menambahkan keterangan
            ]
        ]);

        // Insert data dummy untuk penerbit
        DB::table('penerbits')->insert([
            [
                'nama' => 'Gramedia',
                'contact' => 'contact@gramedia.com',
                'alamat' => 'Jl. Gramedia No. 1, Jakarta',
            ],
            [
                'nama' => 'Erlangga',
                'contact' => 'contact@erlangga.com',
                'alamat' => 'Jl. Erlangga No. 2, Surabaya',
            ]
        ]);

        // Insert data dummy untuk pengarang
        DB::table('pengarangs')->insert([
            [
                'nama' => 'John Doe',
                'biodata' => 'Pengarang buku pemrograman terkenal',
            ],
            [
                'nama' => 'Jane Smith',
                'biodata' => 'Pengarang buku pengembangan web',
            ]
        ]);

        // Insert data dummy untuk buku
        DB::table('bukus')->insert([
            [
                'judul' => 'Belajar Laravel',
                'id_pengarang' => 1,
                'id_penerbit' => 1,
                'id_kategori' => 1,
                'tahun_terbit' => 2023,
            ],
            [
                'judul' => 'PHP Dasar',
                'id_pengarang' => 2,
                'id_penerbit' => 2,
                'id_kategori' => 2,
                'tahun_terbit' => 2022,
            ]
        ]);

        // Insert data dummy untuk peminjaman
        DB::table('peminjamans')->insert([
            [
                'id_user' => 1,
                'id_buku' => 1,
                'tgl_pinjam' => now(),
            ],
            [
                'id_user' => 2,
                'id_buku' => 2,
                'tgl_pinjam' => now(),
            ]
        ]);

        // Insert data dummy untuk sirkulasi
        DB::table('sirkulasis')->insert([
            [
                'id_buku' => 1,
                'id_user' => 1, // Menambahkan id_user
                'status' => 'pinjam',
                'tgl_pinjam' => now(),
                'tgl_kembali' => now()->addDays(7),
                'tgl_pengembalian' => null, // Belum dikembalikan
            ],
            [
                'id_buku' => 2,
                'id_user' => 2, // Menambahkan id_user
                'status' => 'pinjam',
                'tgl_pinjam' => now(),
                'tgl_kembali' => now()->addDays(5),
                'tgl_pengembalian' => null, // Belum dikembalikan
            ]
        ]);

        // Insert data dummy untuk ulasan
        DB::table('ulasans')->insert([
            [
                'id_buku' => 1,
                'id_user' => 1,
                'rating' => 5,
            ],
            [
                'id_buku' => 2,
                'id_user' => 2,
                'rating' => 4,
            ]
        ]);
    }
}
