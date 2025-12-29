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
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // ID User
            $table->string('name'); // Nama
            $table->string('email')->unique(); // <--- KOLOM INI YANG TADI HILANG
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password'); // Password
            
            // Kolom tambahan untuk role & nim
            $table->enum('role', ['admin', 'peminjam'])->default('peminjam');
            $table->string('nim')->nullable();
            
            $table->rememberToken();
            $table->timestamps();
        });

        // Tabel Reset Password & Session (Bawaan Laravel, biarkan saja)
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};