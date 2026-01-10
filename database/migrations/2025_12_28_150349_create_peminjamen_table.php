<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
    Schema::create('peminjamans', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        $table->foreignId('barang_id')->constrained('barangs')->onDelete('cascade');
        
        // --- TAMBAHKAN 2 BARIS INI (Wajib untuk Poin 4) ---
        $table->string('nama'); 
        $table->string('nim');
        // -------------------------------------------------

        $table->date('tgl_pinjam');
        $table->date('tgl_kembali');
        $table->string('durasi')->nullable(); 
        $table->text('keperluan');
        $table->string('file_surat')->nullable(); 

        // Penyesuaian Poin 5: Pastikan status menggunakan Approved agar tombol cetak PDF aktif
        $table->enum('status_approval', ['Pending', 'Approved', 'Rejected'])->default('Pending');
        
        // Tambahan pelengkap: Catatan penolakan (opsional tapi sangat membantu jika statusnya 'Rejected')
        $table->text('catatan_admin')->nullable(); 

        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Perbaikan kecil: Sesuaikan nama tabel dengan yang di atas ('peminjamans')
        Schema::dropIfExists('peminjamans');
    }
};