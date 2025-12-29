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
    Schema::create('qnas', function (Blueprint $table) {
        $table->id();
        
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        $table->string('subjek');
        $table->text('pertanyaan');
        $table->text('jawaban')->nullable();
        $table->enum('status', ['Terkirim', 'Dijawab'])->default('Terkirim');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qnas');
    }
};
