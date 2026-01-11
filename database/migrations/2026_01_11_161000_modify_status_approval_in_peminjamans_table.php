<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Modify the enum to include the new status 'Selesai'
        DB::statement("ALTER TABLE `peminjamans` MODIFY `status_approval` ENUM('Pending','Approved','Rejected','Selesai') NOT NULL DEFAULT 'Pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to original enum without 'Selesai'
        DB::statement("ALTER TABLE `peminjamans` MODIFY `status_approval` ENUM('Pending','Approved','Rejected') NOT NULL DEFAULT 'Pending'");
    }
};
