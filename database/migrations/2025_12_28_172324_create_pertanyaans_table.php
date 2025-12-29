<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pertanyaans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // Siapa yang bertanya
            $table->string('subjek'); // Bisa nama barang atau fasilitas
            $table->text('pertanyaan'); // Isi pertanyaan
            $table->text('jawaban')->nullable(); // Jawaban admin (kosong di awal)
            $table->enum('status', ['Pending', 'Dijawab'])->default('Pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pertanyaans');
    }
};