<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RevertNadiaUserSeeder extends Seeder
{
    public function run()
    {
        // Cari user Nabil
        $user = User::where('email', 'nabil@student.telkomuniversity.ac.id')->first();

        if ($user) {
            $user->update([
                'name' => 'Nadia',
                'nama_lengkap' => 'Nadia Safitri', // Asumsi nama lengkap awal
                'email' => 'nadia@student.telkomuniversity.ac.id',
                'password' => Hash::make('nadia123'),
            ]);
            $this->command->info('User berhasil dikembalikan ke Nadia (nadia@student.telkomuniversity.ac.id).');
        } else {
            // Jika Nabil tidak ketemu, mungkin sudah Nadia? Cek Nadia
            $nadia = User::where('email', 'nadia@student.telkomuniversity.ac.id')->first();
            if ($nadia) {
                // Pastikan password benar
                $nadia->update([
                    'password' => Hash::make('nadia123')
                ]);
                $this->command->info('User Nadia sudah ada. Password di-reset ke nadia123.');
            } else {
                $this->command->error('User tidak ditemukan.');
            }
        }
    }
}
