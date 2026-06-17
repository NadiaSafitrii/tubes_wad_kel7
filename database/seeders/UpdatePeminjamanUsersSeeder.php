<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Peminjaman;
use App\Models\User;

class UpdatePeminjamanUsersSeeder extends Seeder
{
    public function run(): void
    {
        foreach (Peminjaman::all() as $p) {
            if ($p->nim) {
                $user = User::where('nim', $p->nim)->first();
                if ($user) {
                    $p->user_id = $user->id;
                    $p->save();
                }
            }
        }
    }
}
