<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UpdateAdminCredentialsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update Admin
        $admin = User::where('role', 'admin')->first();
        
        if ($admin) {
            $admin->email = 'admin@telkom.io';
            $admin->password = Hash::make('nadia123'); // Updated password request
            $admin->save();
            $this->command->info('Updated Admin: Email set to admin@telkom.io, Password set to nadia123');
        } else {
            $this->command->error('Admin user not found!');
        }
    }
}
