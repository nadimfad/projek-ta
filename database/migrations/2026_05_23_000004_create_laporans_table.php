<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporans', function (Blueprint $table) {
            $table->id('id_laporan');
            $table->foreignId('id_dosen')->constrained('dosens', 'id_dosen')->cascadeOnDelete();
            $table->foreignId('id_kegiatan')->constrained('kegiatans', 'id_kegiatan')->cascadeOnDelete();
            $table->string('nama_mahasiswa');
            $table->string('nim_mahasiswa');
            $table->string('bentuk_gratifikasi');
            $table->date('tanggal_kegiatan');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporans');
    }
};
