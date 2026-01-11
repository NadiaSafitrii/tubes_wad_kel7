<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class CreateFreshUsersSeeder extends Seeder
{
    public function run()
    {
        // Hapus user yang ada (Clean start)
        User::truncate();

        // Buat Admin
        User::create([
            'name' => 'Admin',
            'nama_lengkap' => 'Administrator Logistik',
            'email' => 'admin@telkom.io',
            'password' => Hash::make('nadia123'),
            'role' => 'admin',
            'nim_nip' => 'admin123'
        ]);

        // Buat Mahasiswa (Nadia)
        User::create([
            'name' => 'Nadia',
            'nama_lengkap' => 'Nadia Safitri',
            'email' => 'nadia@student.telkomuniversity.ac.id',
            'password' => Hash::make('nadia123'),
            'role' => 'mahasiswa',
            'nim_nip' => '1202210001'
        ]);

        $this->command->info('Users berhasil dibuat ulang!');
        $this->command->info('Admin: admin@telkom.io / nadia123');
        $this->command->info('Mhs: nadia@student.telkomuniversity.ac.id / nadia123');
    }
}
