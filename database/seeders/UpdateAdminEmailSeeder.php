<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UpdateAdminEmailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update Admin Email
        $admin = User::where('nim_nip', 'admin123')->first();
        if ($admin) {
            $admin->email = 'admin@telkomuniversity.ac.id';
            $admin->save();
            $this->command->info('Email updated for admin123 to: admin@telkomuniversity.ac.id');
        } else {
            $this->command->warn('User admin123 not found');
        }
    }
}
