<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UpdateNabilUserSeeder extends Seeder
{
    public function run()
    {
        // Cari user dengan email lama 'nadia@student.telkomuniversity.ac.id'
        $user = DB::table('users')->where('email', 'nadia@student.telkomuniversity.ac.id')->first();

        if ($user) {
            DB::table('users')
                ->where('id', $user->id)
                ->update([
                    'nama_lengkap' => 'Nabil',
                    'email' => 'nabil@student.telkomuniversity.ac.id',
                    // 'updated_at' => now(), // Omitted to avoid potential unknown column error
                ]);
            
            $this->command->info('User Nadia berhasil diupdate menjadi Nabil!');
        } else {
            // Cek jika Nabil sudah ada
            $nabil = DB::table('users')->where('email', 'nabil@student.telkomuniversity.ac.id')->first();
            if ($nabil) {
                 $this->command->info('User Nabil sudah ada.');
            } else {
                // Buat baru
                DB::table('users')->insert([
                    'nama_lengkap' => 'Nabil',
                    'email' => 'nabil@student.telkomuniversity.ac.id',
                    'nim_nip' => '1202210001',
                    'password' => Hash::make('nadia123'), 
                    'role' => 'mahasiswa',
                ]);
                $this->command->info('User Nabil baru berhasil dibuat!');
            }
        }
    }
}
