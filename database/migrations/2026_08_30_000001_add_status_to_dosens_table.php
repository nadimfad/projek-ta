<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('dosens') || Schema::hasColumn('dosens', 'status')) {
            return;
        }

        Schema::table('dosens', function (Blueprint $table) {
            $table->enum('status', ['aktif', 'non_aktif', 'cuti'])->default('aktif')->after('email');
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('dosens') || ! Schema::hasColumn('dosens', 'status')) {
            return;
        }

        Schema::table('dosens', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
