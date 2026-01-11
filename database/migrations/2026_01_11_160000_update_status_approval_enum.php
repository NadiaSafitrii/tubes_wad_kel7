<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Using raw SQL to avoid doctrine/dbal dependency issues with ENUMs
        DB::statement("ALTER TABLE peminjamans MODIFY COLUMN status_approval ENUM('Pending', 'Approved', 'Rejected', 'Selesai') DEFAULT 'Pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE peminjamans MODIFY COLUMN status_approval ENUM('Pending', 'Approved', 'Rejected') DEFAULT 'Pending'");
    }
};
