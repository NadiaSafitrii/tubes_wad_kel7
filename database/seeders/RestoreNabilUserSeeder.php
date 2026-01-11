<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

class RestoreNabilUserSeeder extends Seeder
{
    public function run()
    {
        // Disable Foreign Key Check force truncate
        Schema::disableForeignKeyConstraints();
        
        User::truncate();

        Schema::enableForeignKeyConstraints();

        // 1. Create Admin
        User::create([
            'name' => 'Admin', // Column is name
            'email' => 'admin@telkom.io',
            'password' => Hash::make('nadia123'),
            'role' => 'admin', // Enum allow admin
            'nim' => 'admin123' // Column is nim
        ]);

        // 2. Create Mahasiswa (Nabil)
        User::create([
            'name' => 'Nabil', // Column is name
            'email' => 'nabil@student.telkomuniversity.ac.id',
            'password' => Hash::make('nadia123'),
            'role' => 'peminjam', // Enum allows peminjam (mapped as mahasiswa in logic)
            'nim' => '1202210001' // Column is nim
        ]);

        $this->command->info('Database Users telah dipulihkan ke posisi: Nabil & Admin.');
    }
}
