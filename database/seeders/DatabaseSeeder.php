<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash; // <--- Wajib ada

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Akun ADMIN
        User::create([
            'name' => 'Admin Logistik',
            'email' => 'admin@telkom.io',
            'password' => Hash::make('admin123'), // <--- Wajib pakai Hash::make()
            'role' => 'admin',
            'nim' => null,
        ]);

        // 2. Buat Akun MAHASISWA
        User::create([
            'name' => 'Nadia Sapitri',
            'email' => 'nadiasapitri@student.telkomuniversity.ac.id',
            'password' => Hash::make('nadia123'), // <--- Wajib pakai Hash::make()
            'role' => 'peminjam',
            'nim' => '1301204001',
        ]);
    }
}