<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash; 

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun ADMIN
        User::create([
            'name' => 'Admin Logistik',
            'email' => 'admin@telkom.io',
            'password' => Hash::make('admin123'), 
            'role' => 'admin',
            'nim' => null,
        ]);

        // 2. Akun MAHASISWA
        User::create([
            'name' => 'Nadia Sapitri',
            'email' => 'nadiasapitri@student.telkomuniversity.ac.id',
            'password' => Hash::make('nadia123'), 
            'role' => 'peminjam',
            'nim' => '1301204001',
        ]);
    }
}