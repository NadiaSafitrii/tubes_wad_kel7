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
        $table->date('tgl_pinjam');
        $table->date('tgl_kembali');
        $table->integer('durasi')->nullable(); // Durasi dalam hari
        $table->text('keperluan');
        $table->string('file_surat')->nullable(); // Upload surat PDF
        $table->enum('status_approval', ['Pending', 'Approved', 'Rejected'])->default('Pending');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjamen');
    }
};
