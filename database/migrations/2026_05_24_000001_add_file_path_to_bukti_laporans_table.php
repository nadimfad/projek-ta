<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bukti_laporans', function (Blueprint $table) {
            $table->string('file_path')->nullable()->after('email');
        });
    }

    public function down(): void
    {
        Schema::table('bukti_laporans', function (Blueprint $table) {
            $table->dropColumn('file_path');
        });
    }
};
