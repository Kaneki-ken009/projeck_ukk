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
        Schema::create('inputaspirasi', function (Blueprint $table) {
            $table->id('id_inputaspirasi');
            $table->string('nisn');
            $table->foreignId('id_kategori')->constrained('kategori', 'id_kategori');
            $table->string('lokasi');
            $table->text('ket');
            $table->string('foto')->nullable();
            $table->enum('status', ['menunggu', 'proses', 'selesai'])->default('menunggu');
            $table->timestamp('tgl_inputaspirasi');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inputaspirasi');
    }
};
