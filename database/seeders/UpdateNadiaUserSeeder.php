<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UpdateNadiaUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update Nadia
        $nadia = User::where('nama_lengkap', 'like', '%Nadia Sapitri%')->first();
        if ($nadia) {
            $nadia->email = 'nadia@student.telkomuniversity.ac.id';
            $nadia->password = Hash::make('nadia123');
            $nadia->save();
            $this->command->info('Updated Nadia: Email set to nadia@student.telkomuniversity.ac.id, Password set to nadia123');
        } else {
            // Create if not exists (optional, but good for robustness)
            $nadia = User::create([
                'nama_lengkap' => 'Nadia Sapitri',
                'nim_nip' => '102022400063', // Assuming this NIM based on previous find
                'email' => 'nadia@student.telkomuniversity.ac.id',
                'password' => Hash::make('nadia123'),
                'role' => 'peminjam',
            ]);
            $this->command->info('Created Nadia: Email set to nadia@student.telkomuniversity.ac.id, Password set to nadia123');
        }
    }
}
