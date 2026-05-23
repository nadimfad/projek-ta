<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bukti_laporans', function (Blueprint $table) {
            $table->id('id_bukti');
            $table->foreignId('id_laporan')->constrained('laporans', 'id_laporan')->cascadeOnDelete();
            $table->string('nama');
            $table->string('email');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bukti_laporans');
    }
};
