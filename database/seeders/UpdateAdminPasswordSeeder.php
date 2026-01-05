<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class UpdateAdminPasswordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update Admin
        $admin = User::where('nim_nip', 'admin123')->first();
        if ($admin) {
            $admin->password = Hash::make('admin');
            $admin->save();
            $this->command->info('Password updated for admin123 to: admin');
        } else {
            $this->command->warn('User admin123 not found');
        }
    }
}
