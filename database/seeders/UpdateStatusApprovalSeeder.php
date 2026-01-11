<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateStatusApprovalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Add 'Selesai' to the enum column status_approval in peminjamans table
        DB::statement("ALTER TABLE `peminjamans` MODIFY `status_approval` ENUM('Pending','Approved','Rejected','Selesai') NOT NULL DEFAULT 'Pending'");
    }
}
