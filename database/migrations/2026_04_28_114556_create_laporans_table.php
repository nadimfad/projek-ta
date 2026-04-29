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
        Schema::create('laporans', function (Blueprint $table) {
    $table->id();
    $table->string('nama_pelapor');
    $table->string('email');
    $table->string('kegiatan'); // seminar / sidang
    $table->text('deskripsi');
    $table->string('bukti')->nullable();
    $table->enum('status', ['menunggu', 'diproses', 'selesai'])->default('menunggu');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporans');
    }
};
