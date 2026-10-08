<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            ['nama' => 'Administrator', 'username' => 'admin', 'password' => Hash::make('admin123'), 'role' => 'admin', 'status' => 'aktif', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Kasir Toko', 'username' => 'kasir', 'password' => Hash::make('kasir123'), 'role' => 'kasir', 'status' => 'aktif', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Pemilik Toko', 'username' => 'pemilik', 'password' => Hash::make('pemilik123'), 'role' => 'pemilik', 'status' => 'aktif', 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('kategoris')->insert([
            ['nama_kategori' => 'Makanan', 'keterangan' => 'Produk makanan', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Minuman', 'keterangan' => 'Produk minuman', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Snack', 'keterangan' => 'Camilan', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Sembako', 'keterangan' => 'Kebutuhan pokok', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'ATK', 'keterangan' => 'Alat tulis kantor', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}